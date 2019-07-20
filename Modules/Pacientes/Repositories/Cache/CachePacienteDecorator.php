<?php

namespace Modules\Pacientes\Repositories\Cache;

use Modules\Pacientes\Repositories\PacienteRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePacienteDecorator extends BaseCacheDecorator implements PacienteRepository
{
    public function __construct(PacienteRepository $paciente)
    {
        parent::__construct();
        $this->entityName = 'pacientes.pacientes';
        $this->repository = $paciente;
    }
}
