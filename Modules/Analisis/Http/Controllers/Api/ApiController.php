<?php

namespace Modules\Analisis\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Barryvdh\DomPDF\Facade as PDF;
use Modules\Analisis\Entities\Analisis;
class ApiController
{

    public function getResultado(Request $request){
      if($request->token != '25e5807a7da0425800105c06b65f7c29')
        return '301';
      $analisis = Analisis::where('id', '=', $request->analisis_id)->with(['resultados', 'paciente'])->get();
      if(isset($analisis))
        return $analisis;
    }

    public function generatePdf(Request $request){
      Log::info($request);
      $analisis = Analisis::find(40);
      $action = 'download';
      $boxes = $this->obtener_boxes('download');
      $pdf = PDF::loadView('analisis::pdf.analisis',compact('analisis','boxes','action'));
      $pdf->setPaper('A4', 'portrait');
      return $pdf->download('Analisis-'.$analisis->paciente->cedula.'.pdf');

      //return response()->json(['error' => false, 'pdf' => 'PDF']);
    }

    public function obtener_boxes($action){
      if($action == 'preview')
        $boxes = json_decode(json_encode([
           'cedula_paciente' => ['x' => 1.9, 'y' => 1.4],
           'nombre_paciente' => ['x' => 1.9, 'y' => 2],
           'edad_paciente' => ['x' => 1.9, 'y' => 2.6],
           'sexo_paciente' => ['x' => 1.9, 'y' => 3.2],
           'fecha' => ['x' => 1.9, 'y' => 3.8],
           'cod' => ['x' => 9, 'y' => 3.8],
           'titulo_resultado' => ['x' => 1.9, 'y' => 5.6],
           'resultado' => ['x' => 11.5, 'y' => 7.5],
           'fuera_rango' => ['x' => 14.8, 'y' => 7.5],
           'rango_referencia' => ['x' => 17, 'y' => 7.5],
         ]));
      if($action == 'download')
       $boxes = json_decode(json_encode([
          'cedula_paciente' => ['x' => 1.2, 'y' => 1],
          'nombre_paciente' => ['x' => 1.2, 'y' => 1.4],
          'edad_paciente' => ['x' => 1.2, 'y' => 1.8],
          'sexo_paciente' => ['x' => 1.2, 'y' => 2.2],
          'fecha' => ['x' => 1.2, 'y' => 2.6],
          'cod' => ['x' => 7, 'y' => 2.6],
          'titulo_resultado' => ['x' => 1.2, 'y' => 4.5],
          'resultado' => ['x' => 9, 'y' => 4.5],
          'fuera_rango' => ['x' => 12, 'y' => 4.5],
          'rango_referencia' => ['x' => 14.5, 'y' => 4.5],
        ]));
      if($action == 'print')
      $boxes = json_decode(json_encode([
         'nombre_paciente' => ['x' => 2.1, 'y' => 1.2],
         'edad_paciente' => ['x' => 2.1, 'y' => 1.6],
         'cedula_paciente' => ['x' => 2.1, 'y' => 2],
         'sexo_paciente' => ['x' => 2.1, 'y' => 2.4],
         'fecha' => ['x' => 2.1, 'y' => 2.8],
         'cod' => ['x' => 7.5, 'y' => 2.8],
         'titulo_resultado' => ['x' => 2.1, 'y' => 4.7],
         'resultado' => ['x' => 8.8, 'y' => 4.7],
         'fuera_rango' => ['x' => 11.4, 'y' => 4.7],
         'rango_referencia' => ['x' => 14.3, 'y' => 4.7],
       ]));

       return $boxes;
    }
}
