<?php

namespace Modules\Analisis\Repositories\Cache;

use Modules\Analisis\Repositories\ResultadoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheResultadoDecorator extends BaseCacheDecorator implements ResultadoRepository
{
    public function __construct(ResultadoRepository $resultado)
    {
        parent::__construct();
        $this->entityName = 'analisis.resultados';
        $this->repository = $resultado;
    }
}
