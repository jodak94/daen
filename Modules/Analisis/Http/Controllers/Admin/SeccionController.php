<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Seccion;
use Modules\Analisis\Http\Requests\CreateSeccionRequest;
use Modules\Analisis\Http\Requests\UpdateSeccionRequest;
use Modules\Analisis\Repositories\SeccionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use DB;
use Log;
class SeccionController extends AdminBaseController
{
    /**
     * @var SeccionRepository
     */
    private $seccion;

    public function __construct(SeccionRepository $seccion)
    {
        parent::__construct();

        $this->seccion = $seccion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $seccions = Seccion::orderBy('orden', 'asc')->get();

        return view('analisis::admin.seccions.index', compact('seccions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $backgrounds = DB::table('backgorund_images')->get();
        return view('analisis::admin.seccions.create', compact('backgrounds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSeccionRequest $request
     * @return Response
     */
    public function store(CreateSeccionRequest $request)
    {
        $request['orden'] = count(Seccion::get());
        if(!isset($request->background))
          $request["background"] = 'img/back-resultado-1.jpg';
        $this->seccion->create($request->all());

        return redirect()->route('admin.analisis.seccion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::seccions.title.seccions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Seccion $seccion
     * @return Response
     */
    public function edit(Seccion $seccion)
    {
        return view('analisis::admin.seccions.edit', compact('seccion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Seccion $seccion
     * @param  UpdateSeccionRequest $request
     * @return Response
     */
    public function update(Seccion $seccion, UpdateSeccionRequest $request)
    {
        $this->seccion->update($seccion, $request->all());

        return redirect()->route('admin.analisis.seccion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::seccions.title.seccions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Seccion $seccion
     * @return Response
     */
    public function destroy(Seccion $seccion)
    {
        try {
          $orden = $seccion->orden;
          $this->seccion->destroy($seccion);
          $secciones = Seccion::where('orden', '>', $orden)->get();
          foreach ($secciones as $key => $s) {
            $s->orden = $orden;
            $s->save();
            $orden++;
          }
        } catch (\Exception $e) {
          return redirect()->route('admin.analisis.seccion.index')->withError('Error al elimnar, existen resultados o plantillas que dependen del registro');
        }

        return redirect()->route('admin.analisis.seccion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::seccions.title.seccions')]));
    }

    public function ordenar(Request $request){
      $c = 0;
      foreach ($request->seccion as $id) {
        DB::table('analisis__seccions')->where('id', $id)->update(['orden' => $c]);
        $c++;
      }
      return redirect()->route('admin.analisis.seccion.index')
          ->withSuccess("Orden establecido correctamente");
    }

    public function subseccion(Request $request){
      $seccion = Seccion::find($request->id);
      if(isset($seccion))
        return response()->json(['error' => false, 'subsecciones' => $seccion->subsecciones()->orderBy('orden', 'asc')->get()]);

      return response()->json(['error' => true]);
    }

    public function search_ajax(Request $request){
      $sub = Seccion::select('*', 'titulo as value')
        ->with(['subsecciones' => function($q){
          $q->orderBy('orden');
          $q->with(['determinacion' => function($qsub){
            $qsub->orderBy('orden');
          }]);
        }])
        ->where('titulo', 'like', '%'.$request->term.'%')->take(5)->get()->toArray();

      return response()->json($sub);
    }
}
