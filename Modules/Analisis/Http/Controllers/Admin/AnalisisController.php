<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Analisis;
use Modules\Analisis\Entities\Resultado;
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
                <a  href="'.$download_route.'" class="preview btn btn-default btn-flat" title="Descargar">
                  <i class="fa fa-download"></i>
                </a>
                <a href="'.$print_route.'" class="btn btn-default btn-flat" title="Imprimir" target="_blank">
                  <i class="fa fa-print"></i>
                </a>';
            if(Auth::user()->hasRoleSlug('administrador') || Auth::user()->hasRoleSlug('admin'))
              $html .= '
              <a href="'.$edit_route.'" class="btn btn-default btn-flat" title="Editar">
                <i class="fa fa-pencil"></i>
              </a>
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
         $query->whereDate('created_at', '>=', $this->fechaFormat($re->fecha_desde) );

      if (isset($re->fecha_hasta) && trim($re->fecha_hasta) != '')
         $query->whereDate('created_at', '<=', $this->fechaFormat($re->fecha_hasta) );

       return $query->orderBy('created_at', 'desc');
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
        if($request->has('plantilla') && $request->plantilla != '')
          $plantilla = Plantilla::find($request->plantilla);
        return view('analisis::admin.analises.create', compact('plantilla'));
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

        if(!isset($request->determinacion))
          return response()->json(['error' => true, 'message'=> 'No se encontraron determinaciones']);

        $fuera_rango = [];
        if(isset($request->fuera_rango))
          $fuera_rango = array_keys($request->fuera_rango);

        DB::beginTransaction();
        try{
          $analisis = new Analisis();
          $analisis->paciente_id = $request->paciente_id;
          $analisis->created_by = Auth::user()->id;
          $analisis->save();
          $orden = DB::select('
            select d.id from analisis__seccions s
            join analisis__subseccions ss on ss.seccion_id = s.id join analisis__determinacions d on d.subseccion_id = ss.id
            where d.id in ('.implode(', ', array_keys($request['determinacion'])).')
            order by s.orden, ss.orden;');
          foreach ($orden as $det_id) {
            if(!isset($request->determinacion[$det_id->id]))//valor
              continue;
            $resultado = new Resultado();
            $resultado->determinacion_id = $det_id->id;
            $resultado->analisis_id = $analisis->id;
            $resultado->valor = $request->determinacion[$det_id->id];
            if(in_array($det_id->id, $fuera_rango))
              $resultado->fuera_rango = true;
            else
              $resultado->fuera_rango = false;
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
          $analisis->save();
        } catch (\Exception $e) {
          Log::info('Error al crear el análisis');
          Log::info($e);
          return response()->json(['error' => true, 'message'=> 'Ocurrió un error en el servidor, avisar al administrador.']);
        }
        DB::commit();
        \Session::put('success', 'Análisis guardado exitosamente');
        return response()->json(['error' => false, 'analisis_id'=> $analisis->id]);
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
           'titulo_resultado' => ['x' => 1.9, 'y' => 5.6],
           'resultado' => ['x' => 11.5, 'y' => 7.5],
           'fuera_rango' => ['x' => 14.8, 'y' => 7.5],
           'rango_referencia' => ['x' => 17, 'y' => 7.5],
         ]));
         if($action == 'download' || $action == 'print')
           $boxes = json_decode(json_encode([
              'cedula_paciente' => ['x' => 1.2, 'y' => 1],
              'nombre_paciente' => ['x' => 1.2, 'y' => 1.4],
              'edad_paciente' => ['x' => 1.2, 'y' => 1.8],
              'sexo_paciente' => ['x' => 1.2, 'y' => 2.2],
              'fecha' => ['x' => 1.2, 'y' => 2.6],
              'titulo_resultado' => ['x' => 1.2, 'y' => 4.5],
              'resultado' => ['x' => 9.7, 'y' => 4.5],
              'fuera_rango' => ['x' => 12.5, 'y' => 4.5],
              'rango_referencia' => ['x' => 14.5, 'y' => 4.5],
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
}
