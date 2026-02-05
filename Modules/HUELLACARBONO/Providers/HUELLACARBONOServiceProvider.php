<?php

namespace Modules\HUELLACARBONO\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\HUELLACARBONO\Entities\ProductiveUnit;
use Modules\HUELLACARBONO\Entities\DailyConsumption;
use Carbon\Carbon;

class HUELLACARBONOServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'HUELLACARBONO';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'huellacarbono';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        // Punto rojo en Alertas cuando hay días sin reporte no vistos (solo para líder)
        View::composer('huellacarbono::layouts.partials.navbar', function ($view) {
            $leaderAlertsCount = 0;
            $showLeaderAlertsDot = false;
            if (Auth::check() && function_exists('checkRol') && checkRol('huellacarbono.leader')) {
                $unit = ProductiveUnit::where('leader_user_id', Auth::id())->first();
                if ($unit) {
                    $today = Carbon::today();
                    $currentDates = [];
                    for ($i = 1; $i <= 7; $i++) {
                        $date = $today->copy()->subDays($i);
                        $hasConsumption = DailyConsumption::where('productive_unit_id', $unit->id)
                            ->whereDate('consumption_date', $date)
                            ->exists();
                        if (!$hasConsumption) {
                            $leaderAlertsCount++;
                            $currentDates[] = $date->format('Y-m-d');
                        }
                    }
                    $seenDates = session('leader_alerts_seen_dates', []);
                    sort($currentDates);
                    sort($seenDates);
                    // Mostrar punto solo si hay alertas y aún no las ha visto (o son distintas = alertas nuevas)
                    $showLeaderAlertsDot = $leaderAlertsCount > 0 && ($currentDates !== $seenDates);
                }
            }
            $view->with(compact('leaderAlertsCount', 'showLeaderAlertsDot'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}





