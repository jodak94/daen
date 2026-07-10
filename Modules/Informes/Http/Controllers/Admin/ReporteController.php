<?php

namespace Modules\Informes\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Analisis\Entities\Resultado;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Empresas\Entities\Empresa;

class ReporteController extends AdminBaseController
{
    private $reportes = [
        'pacientes-fuera-de-rango' => [
            'titulo' => 'Pacientes con resultados fuera de rango',
            'descripcion' => 'Listado de pacientes con al menos un resultado fuera del rango de referencia.',
            'ruta' => 'admin.informes.reporte.pacientesFueraDeRango',
        ],
    ];

    public function index()
    {
        $reportes = $this->reportes;

        return view('informes::admin.reportes.index', compact('reportes'));
    }

    public function pacientesFueraDeRango()
    {
        $empresas = ['' => 'Todas', 'particulares' => 'Particulares'] + Empresa::orderBy('nombre')->pluck('nombre', 'id')->toArray();

        return view('informes::admin.reportes.pacientes-fuera-de-rango', compact('empresas'));
    }

    public function pacientesFueraDeRangoPdf(Request $request)
    {
        ini_set('memory_limit', '512M');

        $resultados = $this->buscarResultadosFueraDeRango($request);
        $empresaTitulo = $this->empresaTitulo($request);
        $fechaDesde = $request->filled('fecha_desde') ? Carbon::createFromFormat('d/m/Y', $request->fecha_desde)->format('d/m/y') : null;
        $fechaHasta = $request->filled('fecha_hasta') ? Carbon::createFromFormat('d/m/Y', $request->fecha_hasta)->format('d/m/y') : null;

        $pdf = PDF::loadView('informes::pdf.pacientes-fuera-de-rango', compact('resultados', 'empresaTitulo', 'fechaDesde', 'fechaHasta'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Pacientes-fuera-de-rango.pdf');
    }

    /**
     * La empresa se filtra por paciente.empresa_id (no hay empresa_id en analisis__analises).
     * Si la empresa de un paciente se edita después, sus análisis pasados se reatribuyen
     * a la empresa/particular actual en este reporte, aunque en su momento hayan
     * correspondido a otra empresa.
     */
    private function buscarResultadosFueraDeRango(Request $request)
    {
        $resultados = Resultado::where('fuera_rango', 1)
            ->with(['determinacion', 'analisis.paciente.empresa'])
            ->whereHas('analisis', function ($q) use ($request) {
                if ($request->filled('fecha_desde')) {
                    $q->whereDate('fecha', '>=', $this->fechaFormat($request->fecha_desde));
                }

                if ($request->filled('fecha_hasta')) {
                    $q->whereDate('fecha', '<=', $this->fechaFormat($request->fecha_hasta));
                }

                if ($request->filled('empresa_id')) {
                    $q->whereHas('paciente', function ($qp) use ($request) {
                        if ($request->empresa_id === 'particulares') {
                            $qp->whereNull('empresa_id');
                        } else {
                            $qp->where('empresa_id', $request->empresa_id);
                        }
                    });
                }
            })
            ->get();

        return $resultados->sortBy(function ($resultado) {
            return $resultado->analisis->paciente->apellido . $resultado->analisis->paciente->nombre;
        })->values();
    }

    private function empresaTitulo(Request $request)
    {
        if (!$request->filled('empresa_id')) {
            return null;
        }

        if ($request->empresa_id === 'particulares') {
            return 'Particulares';
        }

        $empresa = Empresa::find($request->empresa_id);

        return $empresa ? $empresa->nombre : null;
    }

    private function fechaFormat($date)
    {
        return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
    }
}
