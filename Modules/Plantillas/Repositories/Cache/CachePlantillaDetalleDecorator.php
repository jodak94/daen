<?php

namespace Modules\Plantillas\Repositories\Cache;

use Modules\Plantillas\Repositories\PlantillaDetalleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePlantillaDetalleDecorator extends BaseCacheDecorator implements PlantillaDetalleRepository
{
    public function __construct(PlantillaDetalleRepository $plantilladetalle)
    {
        parent::__construct();
        $this->entityName = 'plantillas.plantilladetalles';
        $this->repository = $plantilladetalle;
    }
}
