<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Subseccion;
use Modules\Analisis\Entities\Seccion;
use Modules\Analisis\Http\Requests\CreateSubseccionRequest;
use Modules\Analisis\Http\Requests\UpdateSubseccionRequest;
use Modules\Analisis\Repositories\SubseccionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Analisis\Entities\Determinacion;
use DB;
use Log;
class SubseccionController extends AdminBaseController
{
    /**
     * @var SubseccionRepository
     */
    private $subseccion;

    public function __construct(SubseccionRepository $subseccion)
    {
        parent::__construct();

        $this->subseccion = $subseccion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subseccions = $this->subseccion->all();
        return view('analisis::admin.subseccions.index', compact('subseccions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $secciones = Seccion::all()->pluck('titulo', 'id')->toArray();
        return view('analisis::admin.subseccions.create', compact('secciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubseccionRequest $request
     * @return Response
     */
    public function store(CreateSubseccionRequest $request)
    {
        $request['orden'] = count(Subseccion::where('seccion_id', $request->seccion_id)->get());
        $this->subseccion->create($request->all());

        return redirect()->route('admin.analisis.subseccion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::subseccions.title.subseccions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Subseccion $subseccion
     * @return Response
     */
    public function edit(Subseccion $subseccion)
    {
        $secciones = Seccion::all()->pluck('titulo', 'id')->toArray();
        return view('analisis::admin.subseccions.edit', compact('subseccion', 'secciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Subseccion $subseccion
     * @param  UpdateSubseccionRequest $request
     * @return Response
     */
    public function update(Subseccion $subseccion, UpdateSubseccionRequest $request)
    {
        $this->subseccion->update($subseccion, $request->all());

        return redirect()->route('admin.analisis.subseccion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::subseccions.title.subseccions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subseccion $subseccion
     * @return Response
     */
    public function destroy(Subseccion $subseccion)
    {
        $orden = $subseccion->orden;
        $subsecciones = Subseccion::where('seccion_id', $subseccion->seccion_id)->where('orden', '>', 'from')->get();
        foreach ($subsecciones as $key => $sub) {
          $sub->orden = $orden;
          $sub->save();
          $orden++;
        }
        $this->subseccion->destroy($subseccion);

        return redirect()->route('admin.analisis.subseccion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::subseccions.title.subseccions')]));
    }

    public function search_ajax(Request $request){
      $sub = Subseccion::select('*', 'titulo as value')
        ->with(['determinacion'])
        ->where('titulo', 'like', '%'.$request->term.'%')->take(5)->get()->toArray();

      return response()->json($sub);
    }

    public function ordenar(Request $request){
      $c = 0;
      foreach ($request->subsecciones as $id) {
        DB::table('analisis__subseccions')->where('id', $id)->update(['orden' => $c]);
        $c++;
      }
      return response()->json(['error' => false, 'message' => 'Orden establecido correctamente']);
    }
}
