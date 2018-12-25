<?php

namespace Modules\Analisis\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Analisis\Events\Handlers\RegisterAnalisisSidebar;

class AnalisisServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterAnalisisSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('analises', array_dot(trans('analisis::analises')));
            $event->load('seccions', array_dot(trans('analisis::seccions')));
            $event->load('resultados', array_dot(trans('analisis::resultados')));
            $event->load('determinacions', array_dot(trans('analisis::determinacions')));
            $event->load('plantillas', array_dot(trans('analisis::plantillas')));
            // append translations






        });
    }

    public function boot()
    {
        $this->publishConfig('analisis', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Analisis\Repositories\AnalisisRepository',
            function () {
                $repository = new \Modules\Analisis\Repositories\Eloquent\EloquentAnalisisRepository(new \Modules\Analisis\Entities\Analisis());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Analisis\Repositories\Cache\CacheAnalisisDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Analisis\Repositories\SeccionRepository',
            function () {
                $repository = new \Modules\Analisis\Repositories\Eloquent\EloquentSeccionRepository(new \Modules\Analisis\Entities\Seccion());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Analisis\Repositories\Cache\CacheSeccionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Analisis\Repositories\ResultadoRepository',
            function () {
                $repository = new \Modules\Analisis\Repositories\Eloquent\EloquentResultadoRepository(new \Modules\Analisis\Entities\Resultado());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Analisis\Repositories\Cache\CacheResultadoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Analisis\Repositories\DeterminacionRepository',
            function () {
                $repository = new \Modules\Analisis\Repositories\Eloquent\EloquentDeterminacionRepository(new \Modules\Analisis\Entities\Determinacion());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Analisis\Repositories\Cache\CacheDeterminacionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Analisis\Repositories\PlantillaRepository',
            function () {
                $repository = new \Modules\Analisis\Repositories\Eloquent\EloquentPlantillaRepository(new \Modules\Analisis\Entities\Plantilla());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Analisis\Repositories\Cache\CachePlantillaDecorator($repository);
            }
        );
// add bindings






    }
}
