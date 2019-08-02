<?php

namespace Modules\Empresas\Repositories\Cache;

use Modules\Empresas\Repositories\EmpresaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheEmpresaDecorator extends BaseCacheDecorator implements EmpresaRepository
{
    public function __construct(EmpresaRepository $empresa)
    {
        parent::__construct();
        $this->entityName = 'empresas.empresas';
        $this->repository = $empresa;
    }
}
