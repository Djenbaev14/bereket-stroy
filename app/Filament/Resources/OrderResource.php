<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderWidget;
use App\Models\Customer;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusUpdated;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hydrat\TableLayoutToggle\Concerns\HasToggleableTable;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;
use Filament\Notifications\Notification;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Заказы';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    // public static function navigationBadge(): ?string
    // {
    //     $newOrders = Order::where('order_status_id', 1)->count(); // 1 - yangi zakaz statusi
    //     return $newOrders > 0 ? (string)$newOrders : null; 
    // }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('order_status_id', 1)->count();
    }
    // public static function getWidgets(): array
    // {
    //     return [
    //         OrderWidget::class,
    //     ];
    // }


    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                ->schema([
                    Section::make()
                        ->columnSpan(9)
                        ->columns(12)
                        ->schema([
                            Forms\Components\Select::make('customer_id')
                                ->label('Клиент')
                                ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                                ->options(function () {
                                    return Customer::all()->pluck('first_name', 'id'); // JSON dan 'uz' tilini olish
                                })
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('receiver_name')
                                ->label('Имя получателя')
                                ->required()
                                ->columnSpan(4),
                            Forms\Components\TextInput::make('receiver_phone')
                                ->label('Телефон получателя')
                                ->required()
                                ->columnSpan(4),
                            Forms\Components\Select::make('delivery_method_id')
                                ->label('Способ доставки')
                                ->options(function () {
                                    return DeliveryMethod::all()->pluck('name', 'id'); // JSON dan 'uz' tilini olish
                                })
                                // ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->columnSpan(12)
                                ->reactive(), // O'zgarishni tinglaydi
                            Forms\Components\Select::make('branch_id')
                                ->label('Filial')
                                ->relationship('branch', 'branch_name->ru')
                                ->columnSpan(6)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->hidden(fn ($get) => $get('delivery_method_id') != 1),
                            Forms\Components\TextInput::make('region')
                                ->label('Регион')
                                ->columnSpan(4)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->hidden(fn ($get) => $get('delivery_method_id') != 2), // Agar 2 bo‘lmasa, yashirin bo‘ladi
                                
                            Forms\Components\TextInput::make('district')
                                ->label('Район')
                                ->columnSpan(4)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->hidden(fn ($get) => $get('delivery_method_id') != 2),
                                
                            Forms\Components\TextInput::make('address')
                                ->label('Адрес')
                                ->columnSpan(4)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->hidden(fn ($get) => $get('delivery_method_id') != 2),
                            MapInput::make('location')
                                ->label('Локация')
                                ->saveAsArray()
                                ->placeholder('Choose your location')
                                ->coordinates(59.6022910410232, 42.47038509576842) // start coordinates
                                ->rows(10)
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1)
                                ->hidden(fn ($get) => $get('delivery_method_id') != 2)
                                ->columnSpan(12), // height of map
                            Textarea::make('receiver_comment')
                                ->label('Комментарий')
                                ->columnSpan(12),
                        ]),
                        Section::make()
                            ->columnSpan(3)
                            ->schema([
                                DateTimePicker::make('created_at')
                                ->label('Дата создания')
                                ->disabled(fn ($record) => $record && $record->order_status_id!=3 && $record->created_at->diffInHours(now()) >= 1),
                            
                            ]),
                    Section::make()
                        ->columnSpan(12)
                        ->schema([
                            TextInput::make('total_amount')
                                ->label('Общая сумма')
                                ->disabled(),
                            TableRepeater::make('order_items')
                                ->label('Заказать товары')
                                ->relationship('OrderItems') // order_items jadvaliga bog'lash
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Продукт')
                                        ->relationship('product', 'name->ru') // Product model bilan bog'lash
                                        ->disabled(),

                                    TextInput::make('price')
                                        ->label('Цена')
                                        ->numeric()
                                        ->disabled(),

                                    TextInput::make('quantity')
                                        ->label('Количество')
                                        ->numeric()
                                        ->disabled(),
                                ])->reactive(),
                        ])
                ])
                                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID заказа')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('receiver_name')
                    ->label('Имя получателя')
                    ->searchable(),
                TextColumn::make('total_amount')
                ->label('Общая сумма')
                ->getStateUsing(fn (Order $record) => number_format($record->calculateTotalAmount()) . ' UZS')
                ->sortable()
                ->summarize([
                    Sum::make()
                        ->label('Общая сумма')
                        ->money('UZS'),
                ]),
                TextColumn::make('payment_type.name')
                    ->label('Способ оплаты'),
                TextColumn::make('delivery_method.name')
                        ->label('Тип доставки'),
                TextColumn::make('status.name')
                    ->label('Статус')
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->badge()
                    ->color(fn (Order $record) => match ($record->status->status) {
                        'pending' => 'primary',       // Yangi — Ko‘k
                        'confirmed' => 'info', // Tugallangan — Yashil
                        'processing' => 'info', // Tugallangan — Yashil
                        'delivered' => 'success',   // Bekor qilingan — Qizil
                        'picked_up' => 'success',   // Bekor qilingan — Qizil
                        'cancelled' => 'danger',   // Bekor qilingan — Qizil
                        default => 'danger',
                    }),
                TextColumn::make('payment_status.name')
                    ->label('Статус оплаты')
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->badge()
                    ->color(fn (Order $record) => match ($record->payment_status->type) {
                        'unpaid' => 'primary',       // Yangi — Ko‘k
                        'processing' => 'info', // Tugallangan — Yashil
                        'paid' => 'success', // Tugallangan — Yashil
                        'refunded' => 'danger',   // Bekor qilingan — Qizil
                        default => 'danger',
                    }),
                TextColumn::make('created_at')
                    ->label('Дата заказа')
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)->format('H:i:s d/m/y'); // Sana formatini o‘zgartirish
                    })
                    ->sortable(),
                ],
                )
            ->defaultSort('id', 'desc')
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
            ->defaultPaginationPageOption(50)
            ->defaultSort('id','desc')
            ->actions([
                Action::make('ready')
                    ->label('Готово')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->action(function (Order $record) {
                        $nextStatusId = $record->getNextStatusId();
                        if ($nextStatusId) {
                            if($record->payment_status && $record->payment_status->type === 'paid'){
                                $record->update(['order_status_id' => $nextStatusId]);
                                    // Ekranda bildirishnoma ko‘rsatish
                                    Notification::make()
                                    ->title('Buyurtma holati yangilandi')
                                    // ->body("№{$record->id} Buyurtma holati {$record->status->name} ga o‘zgartirildi.")
                                    ->success()
                                    ->send();
                            }else{
                                Notification::make()
                                ->title("Buyurtmaga to'lov qilinmagan")
                                ->warning()
                                // ->body("№{$record->id} Buyurtma tolov holati {$record->status->name} ga o‘zgartirildi.")
                                // ->success()
                                ->send();
                            }
                        }
                    })
                    ->visible(fn (Order $record): bool => $record->getNextStatusId() !== null),
                Action::make('payment_ready')
                    ->label('Оплата')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->action(function (Order $record) {
                        $nextStatusId = $record->getNextPaymentStatusId();
                        if ($nextStatusId) {
                            $record->update(['payment_status_id' => $nextStatusId]);
                                // Ekranda bildirishnoma ko‘rsatish
                                Notification::make()
                                    ->title("Buyurtma to'lov holati yangilandi")
                                    // ->body("№{$record->id} Buyurtma to'lov holati {$record->payment_status->name} ga o‘zgartirildi.")
                                    ->success()
                                    ->send();
                        }
                    })
                    ->visible(fn (Order $record): bool => $record->getNextPaymentStatusId() !== null && $record->payment_type->payment_method->name!='payment'),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
            ])
            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Дата заказа')
                    ->date()
                    ->collapsible(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
            
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                
        \Filament\Infolists\Components\Grid::make(12)
        ->schema([
            \Filament\Infolists\Components\Section::make('Информация о клиенте')
                ->schema([
                    TextEntry::make('customer.first_name')
                    ->getStateUsing(fn ($record) => "ФИО: {$record->customer->first_name} {$record->customer->last_name}")
                    ->label(''),
                    TextEntry::make('customer.phone')
                    ->getStateUsing(fn ($record) => "Тел номер: {$record->customer->phone}")
                    ->label(''),
                ])->columnSpan(4),
                
                \Filament\Infolists\Components\Section::make('Информация о доставке')
                    ->schema([
                        TextEntry::make('order.branch.name')
                        ->label('')
                        ->getStateUsing(fn ($record) => "Филиал: {$record->branch->branch_name}")
                        ->hidden(fn ($record) => $record->delivery_method->type !== 'pickup'), // ❌ Pickup bo‘lmasa ko‘rinmaydi

                        TextEntry::make('order.region')
                            ->label('')
                            ->getStateUsing(fn ($record) => "Регион: {$record->region}")
                            ->hidden(fn ($record) => $record->delivery_method->type !== 'courier'), // ❌ Courier bo‘lmasa ko‘rinmaydi

                        TextEntry::make('order.district')
                            ->label('')
                            ->getStateUsing(fn ($record) => "Район: {$record->district}")
                            ->hidden(fn ($record) => $record->delivery_method->type !== 'courier'),

                        TextEntry::make('order.address')
                            ->label('')
                            ->getStateUsing(fn ($record) => "Адрес: {$record->address}")
                            ->hidden(fn ($record) => $record->delivery_method->type !== 'courier'),
                    ])->columnSpan(4),

                \Filament\Infolists\Components\Section::make('Информация о продаже')
                    ->schema([
                        TextEntry::make('id')
                        ->getStateUsing(fn ($record) => "Заказ ид: {$record->id}")
                        ->label(''),
                        TextEntry::make('created_at')
                            ->getStateUsing(fn ($record) => "Дата: {$record->created_at}")
                            // ->dateTime('d.m.Y H:i')
                            ->label(''),
                            TextEntry::make('id')
                            ->getStateUsing(fn ($record) => "Общая сумма: ". number_format($record->total_amount) . ' сум')
                            ->label(''),
                        TextEntry::make('payment_status_id')
                            ->label('')
                            ->formatStateUsing(fn ($record) => 
                                "Статус оплаты: <span style='padding:3px 5px;border-radius:5px;color:#fff;background: " . (($record->payment_status_id == 1 || $record->payment_status_id == 5) ? 'rgb(209, 26, 29)' : '#22bb33') . "'>
                                {$record->payment_status->name}
                                </span>"
                                )
                            ->html(),
                        TextEntry::make('order_status_id')
                            ->label('')
                            ->formatStateUsing(fn ($record) => 
                                "Статус: <span style='padding:3px 5px;border-radius:5px;color:#fff;background: " . (($record->order_status_id == 1 ||$record->order_status_id == 6) ? 'rgb(209, 26, 29)' : '#22bb33') . "'>
                                {$record->status->name}
                                </span>"
                                )
                            ->html()
                    ])->columnSpan(4),
            ]),
                TableRepeatableEntry::make('OrderItems')
                    ->label('Товары в заказе')
                    ->schema([
                        TextEntry::make('product.name')->label('Название'),
                        TextEntry::make('quantity')->label('Кол'),
                        TextEntry::make('price')->label('Цена')
                        ->formatStateUsing(fn ($record) => number_format($record->price, 2, '.', ' ') . ' сум'),
                        TextEntry::make('summa')
                        ->label('Сумма')     
                        ->getStateUsing(fn ($record) => number_format($record->price * $record->quantity, 2, '.', ' ') . ' сум')
                    ])
                    ->striped()
                    ->columnSpan(2),
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
