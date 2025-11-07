<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use App\Nova\User as NovaUser;



class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
    * Bootstrap any application services.
    */
    public function boot(): void
    {
        parent::boot();
        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make('Customers', [
                    MenuItem::resource(NovaUser::class),
                ])->icon('users')->collapsable(),



                ];
            });
            //
            Nova::footer(function ($request) {
                return Blade::render('
              <p class="text-center">Sprex Developed By <a href="https://themyanmardream.net/">The MyanmarDream<a><p>
            ');
            });
            Nova::userTimezone(function (Request $request) {
                if($request->user()) {
                    return $request->user()->timezone;
                }
            });
        }

        /**
        * Register the configurations for Laravel Fortify.
        */
        protected function fortify(): void
        {
            Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
                ])
                ->register();
            }

            /**
            * Register the Nova routes.
            */
            protected function routes(): void
            {
                Nova::routes()
                ->withAuthenticationRoutes(default: true)
                ->withPasswordResetRoutes()
                ->withoutEmailVerificationRoutes()
                ->register();
            }

            /**
            * Register the Nova gate.
            *
            * This gate determines who can access Nova in non-local environments.
            */
            protected function gate(): void
            {
                Gate::define('viewNova', function (User $user) {
                    return in_array($user->email, [
                        auth()->user()->email,
                    ]);
                });
            }

            /**
            * Get the dashboards that should be listed in the Nova sidebar.
            *
            * @return array<int, \Laravel\Nova\Dashboard>
            */
            protected function dashboards(): array
            {
                return [
                    new \App\Nova\Dashboards\Main,
                ];
            }

            /**
            * Get the tools that should be listed in the Nova sidebar.
            *
            * @return array<int, \Laravel\Nova\Tool>
            */
            public function tools(): array
            {
                return [];
            }

            /**
            * Register any application services.
            */
            public function register(): void
            {
                parent::register();

                //
            }

        }
