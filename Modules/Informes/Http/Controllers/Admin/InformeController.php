<?php

namespace Modules\Informes\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Informes\Entities\Informe;
use Modules\Informes\Http\Requests\CreateInformeRequest;
use Modules\Informes\Http\Requests\UpdateInformeRequest;
use Modules\Informes\Repositories\InformeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Analisis\Entities\Analisis;
use Carbon\Carbon;
use DB;
use App\Exports\InformeAnualExport;
use \Excel;
class InformeController extends AdminBaseController
{
      private $meses = [
      'Enero',
      'Febrero',
      'Marzo',
      'Abril',
      'Mayo',
      'Junio',
      'Julio',
      'Agosto',
      'Septiembre',
      'Octubre',
      'Noviembre',
      'Diciembre'
    ];
    public function index(Request $request){
      $mes_actual = Carbon::now()->month;
      $anho = Carbon::now()->year;
      $meses = array_slice($this->meses, 0, $mes_actual);
      $totales_mes = [];
      $meses2 = $this->meses;
      foreach ($meses as $key => $mes) {
        array_push($totales_mes, Analisis::
            whereMonth('created_at', $key + 1)
          ->whereYear('created_at', 2021)
          ->get()
          ->sum('precio')
        );
      }
      $r = $this->getPerDay($mes_actual, Carbon::now()->year);
      $dias = [];
      $total_dias = array_fill(1, Carbon::now()->daysInMonth, 0);
      $dias = array_keys($total_dias);
      $valores_dias = array_column($r, 'total_dia', 'dia');
      foreach ($valores_dias as $key => $valor_dia) {
        $total_dias[intval($key)] = $valor_dia;
      }
      $total_dias = array_values($total_dias);
      return view('informes::admin.informes.index', compact('meses', 'totales_mes', 'mes_actual', 'dias', 'total_dias', 'anho', 'meses2'));
    }

    public function getPerYearAjax(Request $request){
      $mes_actual = Carbon::now()->month;
      $meses = $this->meses;
      if($request->year == Carbon::now()->year)
        $meses = array_slice($this->meses, 0, $mes_actual);
      $totales_mes = [];
      foreach ($meses as $key => $mes) {
        array_push($totales_mes, Analisis::
            whereMonth('created_at', $key + 1)
          ->whereYear('created_at', $request->year)
          ->get()
          ->sum('precio')
        );
      }
      return response()->json(['error' => false, 'meses' => $meses, 'totales_mes' => $totales_mes]);
    }

    public function getPerDayAjax(Request $request){
      $date = Carbon::now();
      $year = $request->year;
      $r = $this->getPerDay($request->mes + 1, $year);
      $date->month = $request->mes + 1;
      $dias = [];
      $total_dias = array_fill(1, $date->daysInMonth, 0);
      $dias = array_keys($total_dias);
      $valores_dias = array_column($r, 'total_dia', 'dia');
      foreach ($valores_dias as $key => $valor_dia) {
        $total_dias[intval($key)] = $valor_dia;
      }
      $total_dias = array_values($total_dias);
      return response()->json(['error' => false, 'dias' => $dias, 'total_dias' => $total_dias, 'mes' => $this->meses[$request->mes]]);
    }

    private function getPerDay($mes, $year){
      $query = "SELECT SUM(precio) AS total_dia, day, substr(day, 1, 2) as dia
        FROM (SELECT *, DATE_FORMAT(created_at, '%d-%m-%Y') AS day FROM analisis__analises) as T
        WHERE MONTH(created_at) = ".$mes."
        AND YEAR (created_at)  = ".$year."
        GROUP BY day order by day
        ";

      return DB::select($query);
    }

    public function exportAnual(Request $request){
      return Excel::download(new InformeAnualExport($request->year), 'InformeAnual' . $request->year . '.xlsx');
    }
}
