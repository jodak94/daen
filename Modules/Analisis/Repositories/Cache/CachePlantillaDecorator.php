<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\PlantillaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePlantillaDecorator extends BaseCacheDecorator implements PlantillaRepository
{
    public function __construct(PlantillaRepository $plantilla)
    {
        parent::__construct();
        $this->entityName = 'analisis.plantillas';
        $this->repository = $plantilla;
    }
}
