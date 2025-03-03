<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderWidget;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // public static function navigationBadge(): ?string
    // {
    //     $newOrders = Order::where('order_status_id', 1)->count(); // 1 - yangi zakaz statusi
    //     return $newOrders > 0 ? (string)$newOrders : null; 
    // }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('order_status_id', 1)->count();
    }
    public static function getWidgets(): array
    {
        return [
            OrderWidget::class,
        ];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('receiver_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('receiver_phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('receiver_comment')
                    ->maxLength(255),
                Forms\Components\TextInput::make('delivery_method_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('branch_id')
                    ->numeric(),
                Forms\Components\TextInput::make('region')
                    ->maxLength(255),
                Forms\Components\TextInput::make('district')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('payment_type_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_status_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('order_status_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('ID заказа')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver_name')
                    ->label('Имя получателя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                ->label('Общая сумма')
                ->getStateUsing(fn (Order $record) => number_format($record->calculateTotalAmount()) . ' UZS')
                ->sortable()
                ->summarize([
                    Tables\Columns\Summarizers\Sum::make()
                        ->label('Общая сумма')
                        ->money('UZS'),
                ]),
                Tables\Columns\TextColumn::make('status.name.ru')
                    ->label('Статус')
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->badge()
                    ->color(fn (Order $record) => match ($record->status->name['en']) {
                        'new' => 'primary',       // Yangi — Ko‘k
                        'completed' => 'success', // Tugallangan — Yashil
                        'cancelled' => 'danger',   // Bekor qilingan — Qizil
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата заказа')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Order from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Order Date')
                    ->date()
                    ->collapsible(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
            
    }
    
    public static function getNavigationLabel(): string
    {
        return 'Заказы'; // Rus tilidagi nom
    }
    public static function getModelLabel(): string
    {
        return 'Заказы'; // Rus tilidagi yakka holdagi nom
    }
    public static function getPluralModelLabel(): string
    {
        return 'Заказы'; // Rus tilidagi ko'plik shakli
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
