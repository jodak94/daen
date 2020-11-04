<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Analisis;
use Modules\Analisis\Entities\Resultado;
use Modules\Analisis\Entities\Determinacion;
use Modules\Analisis\Http\Requests\CreateAnalisisRequest;
use Modules\Analisis\Http\Requests\UpdateAnalisisRequest;
use Modules\Analisis\Repositories\AnalisisRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Auth;
use DB;
use Yajra\DataTables\Facades\DataTables;
use Log;
use Barryvdh\DomPDF\Facade as PDF;
use View;
use Carbon\Carbon;
use Modules\Plantillas\Entities\Plantilla;
use lepiaf\SerialPort\SerialPort;
use lepiaf\SerialPort\Parser\SeparatorParser;
use lepiaf\SerialPort\Configure\TTYConfigure;

class AnalisisController extends AdminBaseController
{
    /**
     * @var AnalisisRepository
     */
    private $analisis;

    public function __construct(AnalisisRepository $analisis)
    {
        parent::__construct();

        $this->analisis = $analisis;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $from = Carbon::now()->startOfMonth()->format('d/m/Y');
        $to =  Carbon::now()->format('d/m/Y');
        return view('analisis::admin.analises.index', compact('from', 'to'));
    }

    public function index_ajax(Request $re){
      $query = $this->query_index_ajax($re);
      $object = Datatables::of($query)
          ->addColumn('acciones', function( $analisis ){
            $edit_route = route('admin.analisis.analisis.edit', $analisis->id);
            $delete_route = route('admin.analisis.analisis.destroy', $analisis->id);
            $print_route = route("admin.analisis.analisis.exportar") . "?action=print&analisis_id=" . $analisis->id;
            $download_route = route("admin.analisis.analisis.exportar") . "?action=download&analisis_id=" . $analisis->id;
            $html = '
              <div class="btn-group">
                <a id="analisis_'.$analisis->id.'" href="javascript:void(0)" class="preview btn btn-default btn-flat" title="Vista Previa">
                  <i class="fa fa-search"></i>
                </a>
                <a  href="'.$download_route.'" class="btn btn-default btn-flat" title="Descargar">
                  <i class="fa fa-download"></i>
                </a>
                <a href="'.$print_route.'" class="btn btn-default btn-flat" title="Imprimir" target="_blank">
                  <i class="fa fa-print"></i>
                </a>
                <a href="'.$edit_route.'" class="btn btn-default btn-flat" title="Editar">
                  <i class="fa fa-pencil"></i>
                </a>';
            if(Auth::user()->hasRoleSlug('administrador') || Auth::user()->hasRoleSlug('admin'))
              $html .= '
              <button class="btn btn-danger btn-flat" title="Eliminar" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'.$delete_route.'">
                <i class="fa fa-trash"></i>
              </button>';

            $html .=  '</div>';
            return $html;
          })
          ->rawColumns(['acciones'])
          ->make(true);
      $data = $object->getData(true);
      return response()->json( $data );
    }

    public function query_index_ajax($re){
       $query = Analisis::select();
       if(isset($re->paciente) && trim($re->paciente) != '')
         $query->whereHas('paciente', function($q) use ($re){
           $q->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like',  '%' . $re->paciente . '%')
              ->orWhere('cedula', 'like', '%' . $re->paciente . '%');
         });

      if (isset($re->fecha_desde) && trim($re->fecha_desde) != '')
         $query->whereDate('fecha', '>=', $this->fechaFormat($re->fecha_desde) );

      if (isset($re->fecha_hasta) && trim($re->fecha_hasta) != '')
         $query->whereDate('fecha', '<=', $this->fechaFormat($re->fecha_hasta) );

      if(isset($re->cont_diario) && trim($re->cont_diario) != '')
         $query->where('cont_diario', $re->cont_diario);

       return $query->orderBy('fecha', 'desc');
   }

   private function fechaFormat($date){
       return date("Y-m-d", strtotime( str_replace('/', '-', $date)));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $plantilla = null;
        if($request->has('plantilla') && $request->plantilla != ''){
          $q = "SELECT d.*, pd.mostrar_subtitulo FROM analisis__seccions s
          JOIN analisis__subseccions ss ON ss.seccion_id = s.id JOIN analisis__determinacions d ON d.subseccion_id = ss.id
          JOIN plantillas__plantilladetalles pd on (pd.determinacion_id = d.id and plantilla_id = " . $request->plantilla . ")
          WHERE d.id IN (SELECT determinacion_id FROM plantillas__plantilladetalles WHERE plantilla_id = " . $request->plantilla . ")
          ORDER BY s.orden, ss.orden, d.orden";
          $dets =  Determinacion::fromQuery($q);
          $plantilla = new \stdClass();
          $plantilla->detalles = $dets;
          $plantilla->last_name_first = DB::select('SELECT last_name_first FROM plantillas__plantillas WHERE id = ' . $request->plantilla)[0]->last_name_first;
        }
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Biernes', 'Sábado', 'Domingo'];
        return view('analisis::admin.analises.create', compact('plantilla', 'dias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAnalisisRequest $request
     * @return Response
     */
    public function store(CreateAnalisisRequest $request)
    {
        if(!isset($request->paciente_id))
          return response()->json(['error' => true, 'message'=> 'No se encontró el paciente']);

        if(!isset($request->cont_diario))
          return response()->json(['error' => true, 'message'=> 'No se encontró el código']);

        if(!isset($request->determinacion) || (isset($request->determinacion) && !count($request->determinacion)))
          return response()->json(['error' => true, 'message'=> 'No se encontraron determinaciones']);

        $fuera_rango = [];
        if(isset($request->fuera_rango))
          $fuera_rango = array_keys($request->fuera_rango);

        $mostrar = [];
        if(isset($request->mostrar))
          $mostrar = array_keys($request->mostrar);

        DB::beginTransaction();
        $analisis = new Analisis();
        $analisis->paciente_id = $request->paciente_id;
        $analisis->last_name_first = $request->last_name_first;
        $analisis->created_by = Auth::user()->id;
        $analisis->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
        $analisis->save();
        $orden = DB::select('
        select d.id from analisis__seccions s
        join analisis__subseccions ss on ss.seccion_id = s.id join analisis__determinacions d on d.subseccion_id = ss.id
        where d.id in ('.implode(', ', array_keys($request['determinacion'])).')
        order by s.orden, ss.orden, d.orden;');
        if($request->procesar_spin){
          try {
            $this->procesamientoSpin($request, $analisis, $orden);
          } catch (\Exception $e) {
            Log::info("----ERROR PROCESAMIENTO SPINLAB----");
            Log::info($e);
            return response()->json(['error' => true, 'message'=> 'Ocurrió un error en la comunicación con el SpinLab.']);
          }
        }
        try{
          $this->procesamientoNormal($request, $analisis, $orden, $fuera_rango, $mostrar);
        } catch (\Exception $e) {
          Log::info("----ERROR PROCESAMIENTO NORMAL----");
          Log::info($e);
          return response()->json(['error' => true, 'message'=> 'Ocurrió un error en el servidor, avisar al administrador.']);
        }
        DB::commit();
        \Session::put('success', 'Análisis guardado exitosamente');
        return response()->json(['error' => false, 'analisis_id'=> $analisis->id]);
    }

    private function procesamientoSpin($request, $analisis, $orden){
      Log::info(array_column($orden, 'id'));
      foreach ($orden as $o) {
        Log::info($o->id);
      }
      $determinaciones = Determinacion::whereIn('id', array_column($orden, 'id'))->get();
      foreach ($determinaciones as $det) {
        Log::info($det->titulo);
      }
      $frame = $this->obtenerFrame($analisis, $determinaciones);
      Log::info($frame);
      dd();
      return;
      $ENQ = '♣';//5
      $ACK = '♠';//6
      $EOT = '♦';//4
      $serialPort = new SerialPort(new SeparatorParser(), new TTYConfigure());
      $serialPort->open("/dev/ttyACM0");
      $serialPort->write($ENQ);
      $finalizado = false;
      while ($data = $serialPort->read()) {
        $det = Determinacion::find($orden[$actual]->id);
        $frame = $this->obtenerFrame($analisis, $determinaciones);
        Log::info($data);
        Log::info($frame);
        if($data == $ACK) {
          $serialPort->write($frame);
          if($finalizado)
            break;
        }


      }
      $serialPort->write($EOT);
      $serialPort->close();
    }

    private function obtenerFrame($analisis, $determinaciones){
      $STX = '☻';//2
      $CR  = '♪';//13
      $LF  = '◙';//10

      $frame  = $STX;     //Inicio
      //---------Header---------
      $frame .= 'H|';                 //Tipo
      $frame .= '\^&|';               //Delimitador
      $frame .= '||||||';             //Message Control ID | Access Password | Sender Name | Sender Addres | Reserved Field  | Sender Phone |
      $frame .= '|||||';              //Charac. of Sender | Receiver ID | Comment or Special Inst. | Processing ID | Version No. | Date and Time of Message
      $frame .= $CR;                  //Carriage Return
      //--------Paciente--------
      $frame .= 'P|';                 //Tipo
      $frame .= '1|';                 //Secuencia
      $frame .= '|';                  //Practice Assigned Patient ID
      $frame .= $analisis->id . '|';  //Laboratory Assigned Patient ID
      $frame .= '|';                  //Patient ID No. 3
      $frame .= $analisis->paciente->nombre . '&' . $analisis->paciente->apellido . '|';  //Pacient Name
      $frame .= $analisis->fecha_nacimiento . '|'; //Fecha de nacimiento
      $frame .= ($analisis->paciente->edad > 15 ? strtoupper($analisis->paciente->sexo[0]) : 'U') . '|';
      $frame .= $CR;
      //Orden
      foreach ($determinaciones as $key => $det) {
        $frame .= 'O|';               //Tipo
        $frame .= $key + 1 . '|';     //Secuencio
        $frame .= $analisis->id;      //ID de la muestra
        $frame .= '|';                //Instrument Speciment ID
        $frame .= substr($det->titulo, 0, 4) . '|'; //Determinación
        $frame .= $CR;
      }
      $frame .= $LF;

      return $frame;
    }

    private function procesamientoNormal($request, $analisis, $orden, $fuera_rango, $mostrar){
      foreach ($orden as $det_id) {
        if(!isset($request->determinacion[$det_id->id]) || $request->determinacion[$det_id->id] == ':')//si esta vacio o es : (vacio para antibiograma)
          continue;
        $resultado = new Resultado();
        $resultado->determinacion_id = $det_id->id;
        $resultado->analisis_id = $analisis->id;
        $resultado->valor = $request->determinacion[$det_id->id];
        $sub_id = DB::select('SELECT sub.id FROM analisis__subseccions sub join analisis__determinacions det on sub.id = det.subseccion_id where det.id = ' . $det_id->id)[0]->id;
        $resultado->mostrar_subtitulo = in_array($sub_id, $mostrar);
        $resultado->fuera_rango = in_array($det_id->id, $fuera_rango);
        $resultado->save();
      }
      if($request->has('analisis_id') && trim($request->analisis_id) != ''){
        $analisis_to_remove = Analisis::find($request->analisis_id);
        $analisis->created_by = $analisis_to_remove->created_by;
        $analisis->modified_by = Auth::user()->id;
        $analisis->created_at = $analisis_to_remove->created_at;
        $analisis->updated_at = $analisis_to_remove->updated_at;
        $analisis_to_remove->delete();
      }else{
        $analisis->created_by = Auth::user()->id;
      }
      $analisis->cont_diario = $request->cont_diario;
      $analisis->save();
    }

    public function export_to_pdf(Request $request) {
        $analisis = Analisis::find($request->analisis_id);
        $action = $request->action;
        $boxes = $this->obtener_boxes($action);
        if($action == 'download') {
            $pdf = PDF::loadView('analisis::pdf.analisis',compact('analisis','boxes','action'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download('Analisis-'.$analisis->paciente->cedula.'.pdf');
        }else {
            if($action == 'print') {
                $pdf = PDF::loadView('analisis::pdf.analisis',compact('analisis','boxes','action'));
                $pdf->setPaper('A4', 'portrait');
                return $pdf->stream('Analisis-'.$analisis->paciente->cedula.'.pdf');
            }else {
                $view = View::make('analisis::pdf.analisis',compact('analisis','boxes','action'));
                return $view->render();
            }
        }
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
          'resultado' => ['x' => 9.5, 'y' => 4.5],
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Analisis $analisis
     * @return Response
     */
    public function edit(Analisis $analisis)
    {
        $edit = true;
        return view('analisis::admin.analises.edit', compact('analisis', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Analisis $analisis
     * @param  UpdateAnalisisRequest $request
     * @return Response
     */
    public function update(Analisis $analisis, UpdateAnalisisRequest $request)
    {
        $this->analisis->update($analisis, $request->all());

        return redirect()->route('admin.analisis.analisis.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::analises.title.analises')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Analisis $analisis
     * @return Response
     */
    public function destroy(Analisis $analisis)
    {
        $this->analisis->destroy($analisis);

        return redirect()->route('admin.analisis.analisis.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::analises.title.analises')]));
    }

    public function resetCont(){
      DB::table('configuraciones')->where('key', 'cont_diario')->update(['value' => 0]);

      return response()->json(['success' => true]);
    }

    public function preconfigurar(Request $request){
      $mostrar = [];
      if(isset($request->mostrar))
        $mostrar = array_keys($request->mostrar);

      DB::beginTransaction();
      $analisis = new Analisis();
      $analisis->paciente_id = $request->paciente_id;
      $analisis->created_by = Auth::user()->id;
      $analisis->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha);
      $analisis->save();
      $orden = DB::select('
      select d.id from analisis__seccions s
      join analisis__subseccions ss on ss.seccion_id = s.id join analisis__determinacions d on d.subseccion_id = ss.id
      where d.id in ('.implode(', ', array_keys($request['determinacion'])).')
      order by s.orden, ss.orden, d.orden;');
      //------//
      foreach ($orden as $det_id) {
        $resultado = new Resultado();
        $resultado->determinacion_id = $det_id->id;
        $resultado->analisis_id = $analisis->id;
        $sub_id = DB::select('SELECT sub.id FROM analisis__subseccions sub join analisis__determinacions det on sub.id = det.subseccion_id where det.id = ' . $det_id->id)[0]->id;
        $resultado->mostrar_subtitulo = in_array($sub_id, $mostrar);
        $resultado->save();
      }
      $analisis->cont_diario = $request->cont_diario;
      $analisis->save();
      DB::commit();
      \Session::put('success', 'Análisis creado exitosamente');
      $edit = true;
      return view('analisis::admin.analises.edit', compact('analisis', 'edit'));
    }
}
