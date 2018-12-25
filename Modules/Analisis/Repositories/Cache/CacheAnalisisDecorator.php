<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\AnalisisRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAnalisisDecorator extends BaseCacheDecorator implements AnalisisRepository
{
    public function __construct(AnalisisRepository $analisis)
    {
        parent::__construct();
        $this->entityName = 'analisis.analises';
        $this->repository = $analisis;
    }
}
