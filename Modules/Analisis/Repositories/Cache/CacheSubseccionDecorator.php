<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\SubseccionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSubseccionDecorator extends BaseCacheDecorator implements SubseccionRepository
{
    public function __construct(SubseccionRepository $subseccion)
    {
        parent::__construct();
        $this->entityName = 'analisis.subseccions';
        $this->repository = $subseccion;
    }
}
