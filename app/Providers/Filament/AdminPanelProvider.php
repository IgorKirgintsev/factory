<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Settings;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            ->databaseNotifications()   // уведомлениея базы данных
        //  ->navigation(false)
        //   >topbar(false)
        //  ->topNavigation()
            ->default()
            ->id('app')
            ->path('/')
            ->login()
            ->registration()
            ->spa()
            ->brandName('Производство и продажа металлоизделий')
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([

//               Pages\Dashboard::class,
                 ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
               ])
            ->userMenuItems([

//                 MenuItem::make()
//                 ->label('Настройка')
//                 ->url(fn (): string => Settings::getUrl())
//                 ->icon('heroicon-o-cog-6-tooth'),
                // ...
                 ])
            ->navigationGroups([

                NavigationGroup::make()
                ->label('Изделия')
                ->collapsible(false),

                NavigationGroup::make()
                ->label('Магазин')
                ->collapsible(false),

                NavigationGroup::make()
                ->label('Отчеты')
                ->collapsible(true),

                NavigationGroup::make()
                 ->label('Справочники')
                 ->collapsible(true),

                 NavigationGroup::make()
                 ->label('Настройка')
                 ->collapsible(true),
                //        ->collapsed(),



                 ])


            ->navigationItems([
//                 NavigationItem::make('Аналитика')
//                  ->url('https://filament.pirsch.io', shouldOpenInNewTab: true)
//                  ->icon('heroicon-o-presentation-chart-line')
//                  ->group('Отчеты'),
//                NavigationItem::make('Отчеты по оплатам')
//                   ->group('Отчеты')
//                   ->icon('heroicon-o-clipboard-document-list')
//                   ->url(fn (): string => Settings::getUrl()),   // работает

                    //NavigationItem::make('dashboard')
                        //->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                        //->url(fn (): string => Dashboard::getUrl())
                        //->isActiveWhen(fn () => request()->routeIs('filament.admin.pages.dashboard')),
                    // ...
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
