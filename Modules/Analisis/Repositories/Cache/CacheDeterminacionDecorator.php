<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\DeterminacionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDeterminacionDecorator extends BaseCacheDecorator implements DeterminacionRepository
{
    public function __construct(DeterminacionRepository $determinacion)
    {
        parent::__construct();
        $this->entityName = 'analisis.determinacions';
        $this->repository = $determinacion;
    }
}
