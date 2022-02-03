<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Determinacion;
use Modules\Analisis\Entities\Subseccion;
use Modules\Analisis\Http\Requests\CreateDeterminacionRequest;
use Modules\Analisis\Http\Requests\UpdateDeterminacionRequest;
use Modules\Analisis\Repositories\DeterminacionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\DataTables\Facades\DataTables;
use Log;
use DB;
class DeterminacionController extends AdminBaseController
{
    /**
     * @var DeterminacionRepository
     */
    private $determinacion;

    public function __construct(DeterminacionRepository $determinacion)
    {
        parent::__construct();

        $this->determinacion = $determinacion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('analisis::admin.determinacions.index');
    }

    public function index_ajax(Request $re){
      $query = $this->query_index_ajax($re);
      $object = Datatables::of($query)
          ->addColumn('acciones', function( $det ){
            $edit_route = route('admin.analisis.determinacion.edit', $det->id);
            $delete_route = route('admin.analisis.determinacion.destroy', $det->id);
            $html = '
              <div class="btn-group">
                <a href="'.$edit_route.'" class="btn btn-default btn-flat" title="Editar">
                  <i class="fa fa-pencil"></i>
                </a>
                <button class="btn btn-danger btn-flat" title="Eliminar" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'.$delete_route.'">
                  <i class="fa fa-trash"></i>
                  </button>
              </div>';

            return $html;
          })
          ->editColumn('subseccion_titulo', function($det){
            return $det->subseccion->titulo;
          })
          ->rawColumns(['acciones'])
          ->make(true);
      $data = $object->getData(true);
      return response()->json( $data );
    }

    public function query_index_ajax($re){
      $query = Determinacion::select();
      if (isset($re->titulo) && trim($re->titulo) != '')
         $query->where('titulo', 'like', '%'.$re->titulo.'%' );

       return $query;
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $subsecciones = Subseccion::all()->pluck('titulo', 'id')->toArray();
        $tipos_refs = Determinacion::$tipos_refs;
        $tipos_tratos = Determinacion::$tipos_tratos;
        return view('analisis::admin.determinacions.create', compact('subsecciones', 'tipos_refs', 'tipos_tratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDeterminacionRequest $request
     * @return Response
     */
    public function store(CreateDeterminacionRequest $request)
    {
        switch ($request->tipo_referencia) {
          case 'rango_edad':
            $request['rango_referencia'] = 'Niños ' .  $request->rango_referencia_ninhos_inferior . '-' . $request->rango_referencia_ninhos_superior . ' | Adultos ' .  $request->rango_referencia_adultos_inferior . '-' . $request->rango_referencia_adultos_superior;
            break;
          case 'rango_sexo':
            $request['rango_referencia'] = 'Fem ' .  $request->rango_referencia_femenino_inferior . '-' . $request->rango_referencia_femenino_superior . ' | Masc ' .  $request->rango_referencia_masculino_inferior . '-' . $request->rango_referencia_masculino_superior;
            break;
          case 'rango':
            $request['rango_referencia'] = $request->rango_referencia_inferior . '-' . $request->rango_referencia_superior;
            break;
          case 'sin_referencia':
            unset($request['rango_referencia']);
            break;
          default:
            $request['rango_referencia'] = strtolower(str_replace(' ', '_', $request->rango_referencia));
            break;
        }
        $request['orden'] = count(Determinacion::where('subseccion_id', $request->subseccion_id)->get());

        if(!isset($request->cantidad_decimales));
          $request['cantidad_decimales'] = 1;

        $this->determinacion->create($request->all());

        return redirect()->route('admin.analisis.determinacion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::determinacions.title.determinacions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Determinacion $determinacion
     * @return Response
     */
    public function edit(Determinacion $determinacion)
    {
        $subsecciones = Subseccion::all()->pluck('titulo', 'id')->toArray();
        switch ($determinacion->tipo_referencia) {
          case 'rango_hasta':
          case 'rango':
            $rango = explode('-', $determinacion->rango_referencia);
            break;
          case 'rango_sexo':
            $rango =  explode('-', str_replace('|', '-', preg_replace('/[^0-9\-|.,]/', '', $determinacion->rango_referencia)));
            break;
          case 'rango_edad':
            $rango =  explode('-', str_replace('|', '-', preg_replace('/[^0-9\-|.,]/', '', $determinacion->rango_referencia)));
            break;
          case 'sin_referencia':
            $rango = null;
          default:
            $rango = $determinacion->rango_referencia;
        }
        $determinacion->rango = $rango;
        $tipos_refs = Determinacion::$tipos_refs;
        $tipos_tratos = Determinacion::$tipos_tratos;
        // dd($determinacion->unidad_medida);
        return view('analisis::admin.determinacions.edit', compact('determinacion', 'subsecciones', 'tipos_refs', 'tipos_tratos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Determinacion $determinacion
     * @param  UpdateDeterminacionRequest $request
     * @return Response
     */
    public function update(Determinacion $determinacion, UpdateDeterminacionRequest $request)
    {
        switch ($request->tipo_referencia) {
          case 'rango_edad':
            $request['rango_referencia'] = 'Niños ' .  $request->rango_referencia_ninhos_inferior . '-' . $request->rango_referencia_ninhos_superior . ' | Adultos ' .  $request->rango_referencia_adultos_inferior . '-' . $request->rango_referencia_adultos_superior;
            break;
          case 'rango_sexo':
            $request['rango_referencia'] = 'Fem ' .  $request->rango_referencia_femenino_inferior . '-' . $request->rango_referencia_femenino_superior . ' | Masc ' .  $request->rango_referencia_masculino_inferior . '-' . $request->rango_referencia_masculino_superior;
            break;
          case 'rango':
            $request['rango_referencia'] = $request->rango_referencia_inferior . '-' . $request->rango_referencia_superior;
            break;
          case 'sin_referencia':
            $request['rango_referencia'] = null;
            break;
          case 'clase_o':
            $request['rango_referencia'] = 'clase_o';
          default:
            $request['rango_referencia'] = strtolower(str_replace(' ', '_', $request->rango_referencia));
            break;
        }
        $this->determinacion->update($determinacion, $request->all());

        return redirect()->route('admin.analisis.determinacion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::determinacions.title.determinacions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Determinacion $determinacion
     * @return Response
     */
    public function destroy(Determinacion $determinacion)
    {
        try {
          $orden = $determinacion->orden;
          $determinaciones = Determinacion::where('subseccion_id', $determinacion->subseccion_id)->where('orden', '>', $orden)->get();
          $this->determinacion->destroy($determinacion);
          foreach ($determinaciones as $key => $det) {
            $det->orden = $orden;
            $det->save();
            $orden++;
          }
        } catch (\Exception $e) {
          Log::info($e);
          return redirect()->route('admin.analisis.determinacion.index')->withError('Error al elimnar, existen resultados o plantillas que dependen del registro');
        }

        return redirect()->route('admin.analisis.determinacion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::determinacions.title.determinacions')]));
    }

    public function ordenar(Request $request){
      $c = 0;
      foreach ($request->determinaciones as $id) {
        DB::table('analisis__determinacions')->where('id', $id)->update(['orden' => $c]);
        $c++;
      }
      return response()->json(['error' => false, 'message' => 'Orden establecido correctamente']);
    }

    public function search_ajax(Request $request){
      $det = Determinacion::select('analisis__determinacions.*', DB::raw("CONCAT(analisis__determinacions.titulo, ' - ', ss.titulo) as value"))
        ->join('analisis__subseccions as ss', 'analisis__determinacions.subseccion_id', '=', 'ss.id')
        ->with(['subseccion' => function($q){
          $q->select('id', 'titulo', 'mostrar');
        }])
        ->where('analisis__determinacions.titulo', 'like', '%'.$request->term.'%')
        ->where('ss.titulo', '!=', 'Indices Hematimetricos')->take(8)->get()->toArray();

      return response()->json($det);
    }
}
