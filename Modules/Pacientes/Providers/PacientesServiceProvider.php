<?php

namespace Modules\Pacientes\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Pacientes\Events\Handlers\RegisterPacientesSidebar;

class PacientesServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPacientesSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('pacientes', array_dot(trans('pacientes::pacientes')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('pacientes', 'permissions');

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
            'Modules\Pacientes\Repositories\PacienteRepository',
            function () {
                $repository = new \Modules\Pacientes\Repositories\Eloquent\EloquentPacienteRepository(new \Modules\Pacientes\Entities\Paciente());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Pacientes\Repositories\Cache\CachePacienteDecorator($repository);
            }
        );
// add bindings

    }
}
