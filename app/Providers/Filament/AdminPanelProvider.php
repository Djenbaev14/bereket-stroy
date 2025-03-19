<?php

namespace App\Providers\Filament;

use A21ns1g4ts\FilamentShortUrl\FilamentShortUrlPlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Facades\Filament;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Hydrat\TableLayoutToggle\TableLayoutTogglePlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use MarcoGermani87\FilamentCaptcha\FilamentCaptcha;
class AdminPanelProvider extends PanelProvider
{

    
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Auth\Login::class)
            ->colors([
                'primary' => Color::Yellow,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->plugins([
                FilamentApexChartsPlugin::make(),
                FilamentShortUrlPlugin::make(),
                SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales(['ru', 'uz','qr', 'en']),
                FilamentCaptcha::make(),
            ])
            ->renderHook(
                // PanelsRenderHook::BODY_END,
                PanelsRenderHook::FOOTER,
                fn() => view('footer')
            )
            ->favicon(asset('images/favicon.svg'))
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Продукты')
                    ->icon('fas-list'),
                NavigationGroup::make()
                    ->label('Пользователи')
                    ->icon('fas-user'),
                NavigationGroup::make()
                     ->label('Заказы')
                     ->icon('fas-list-check'),
                NavigationGroup::make()
                     ->label('Настройки')
                     ->icon('fas-sliders'),
            ])
            ->spa()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->topNavigation()
            ->brandLogo(asset('images/LOGO.png'))
            ->brandLogoHeight(100)
            ->darkModeBrandLogo(asset('images/darkmode.png'))
            ->brandName('Bereket Stroy')
            ->font('Inter', provider: GoogleFontProvider::class)
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
                    ->canViewThemesPage(fn () => auth()->check() && auth()->user()?->hasRole('super_admin'))
            )
            ->middleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            // or in `tenantMiddleware` if you're using multi-tenancy
            ->tenantMiddleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->plugins([
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 2
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
