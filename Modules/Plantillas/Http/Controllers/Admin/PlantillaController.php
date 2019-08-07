<?php

namespace Modules\Plantillas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Plantillas\Entities\Plantilla;
use Modules\Plantillas\Http\Requests\CreatePlantillaRequest;
use Modules\Plantillas\Http\Requests\UpdatePlantillaRequest;
use Modules\Plantillas\Repositories\PlantillaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Plantillas\Entities\PlantillaDetalle;
use DB;
use Log;
class PlantillaController extends AdminBaseController
{
    /**
     * @var PlantillaRepository
     */
    private $plantilla;

    public function __construct(PlantillaRepository $plantilla)
    {
        parent::__construct();

        $this->plantilla = $plantilla;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $plantillas = $this->plantilla->all();
        return view('plantillas::admin.plantillas.index', compact('plantillas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('plantillas::admin.plantillas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlantillaRequest $request
     * @return Response
     */
    public function store(CreatePlantillaRequest $request)
    {
      DB::beginTransaction();
      try{
        $plantilla = new Plantilla();
        $plantilla->nombre = $request->nombre;
        $plantilla->save();
        $orden = DB::select('
          select d.id from analisis__seccions s
          join analisis__subseccions ss on ss.seccion_id = s.id join analisis__determinacions d on d.subseccion_id = ss.id
          where d.id in ('.implode(', ', array_keys($request['determinacion'])).')
          order by s.orden, ss.orden;');
        foreach ($orden as $det_id) {
          $detalle = new PlantillaDetalle();
          $detalle->plantilla_id = $plantilla->id;
          $detalle->determinacion_id = $det_id->id;
          $detalle->save();
        }
      } catch (\Exception $e) {
        Log::info('Error al crear la Plantilla');
        Log::info($e);
        return redirect()->back()->withError('Ocurrió un error en el servidor, avisar al administrador.');
      }
      DB::commit();
      return redirect()->route('admin.plantillas.plantilla.index')->withSuccess('Plantilla creado exitosamente.');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Plantilla $plantilla
     * @return Response
     */
    public function edit(Plantilla $plantilla)
    {

        return view('plantillas::admin.plantillas.edit', compact('plantilla'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Plantilla $plantilla
     * @param  UpdatePlantillaRequest $request
     * @return Response
     */
    public function update(Plantilla $plantilla_to_remove, UpdatePlantillaRequest $request)
    {
        DB::beginTransaction();
        try{
          $plantilla = new Plantilla();
          $plantilla->nombre = $request->nombre;
          $plantilla->created_at = $plantilla_to_remove->created_at;
          $plantilla->save();
          $orden = DB::select('
            select d.id from analisis__seccions s
            join analisis__subseccions ss on ss.seccion_id = s.id join analisis__determinacions d on d.subseccion_id = ss.id
            where d.id in ('.implode(', ', array_keys($request['determinacion'])).')
            order by s.orden, ss.orden;');
          foreach ($orden as $det_id) {
            Log::info($det_id->id);
            $detalle = new PlantillaDetalle();
            $detalle->plantilla_id = $plantilla->id;
            $detalle->determinacion_id = $det_id->id;
            $detalle->save();
          }
          $this->plantilla->destroy($plantilla_to_remove);
        } catch (\Exception $e) {
          Log::info('Error al crear la Plantilla');
          Log::info($e);
          return redirect()->back()->withError('Ocurrió un error en el servidor, avisar al administrador.');
        }
        DB::commit();

        return redirect()->route('admin.plantillas.plantilla.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('plantillas::plantillas.title.plantillas')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Plantilla $plantilla
     * @return Response
     */
    public function destroy(Plantilla $plantilla)
    {
        $this->plantilla->destroy($plantilla);

        return redirect()->route('admin.plantillas.plantilla.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('plantillas::plantillas.title.plantillas')]));
    }

    public function search_ajax(Request $request){
      Log::info($request->term);
      $sub = Plantilla::select('*', 'nombre as value')
        ->where('nombre', 'like', '%'.$request->term.'%')->take(5)->get()->toArray();

      Log::info($sub);
      return response()->json($sub);
    }
}
