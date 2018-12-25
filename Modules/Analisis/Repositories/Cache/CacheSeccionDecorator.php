<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\SeccionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSeccionDecorator extends BaseCacheDecorator implements SeccionRepository
{
    public function __construct(SeccionRepository $seccion)
    {
        parent::__construct();
        $this->entityName = 'analisis.seccions';
        $this->repository = $seccion;
    }
}
