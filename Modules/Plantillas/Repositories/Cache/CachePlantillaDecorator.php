<?php

namespace Modules\Plantillas\Repositories\Cache;

use Modules\Plantillas\Repositories\PlantillaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePlantillaDecorator extends BaseCacheDecorator implements PlantillaRepository
{
    public function __construct(PlantillaRepository $plantilla)
    {
        parent::__construct();
        $this->entityName = 'plantillas.plantillas';
        $this->repository = $plantilla;
    }
}
