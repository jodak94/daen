<?php

namespace Modules\Plantillas\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Plantillas\Events\Handlers\RegisterPlantillasSidebar;

class PlantillasServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPlantillasSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('plantillas', array_dot(trans('plantillas::plantillas')));
            $event->load('plantilladetalles', array_dot(trans('plantillas::plantilladetalles')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('plantillas', 'permissions');

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
            'Modules\Plantillas\Repositories\PlantillaRepository',
            function () {
                $repository = new \Modules\Plantillas\Repositories\Eloquent\EloquentPlantillaRepository(new \Modules\Plantillas\Entities\Plantilla());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Plantillas\Repositories\Cache\CachePlantillaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Plantillas\Repositories\PlantillaDetalleRepository',
            function () {
                $repository = new \Modules\Plantillas\Repositories\Eloquent\EloquentPlantillaDetalleRepository(new \Modules\Plantillas\Entities\PlantillaDetalle());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Plantillas\Repositories\Cache\CachePlantillaDetalleDecorator($repository);
            }
        );
// add bindings


    }
}
