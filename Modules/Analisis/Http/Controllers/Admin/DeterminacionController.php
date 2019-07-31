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
        $determinacions = $this->determinacion->all();

        return view('analisis::admin.determinacions.index', compact('determinacions'));
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
        return view('analisis::admin.determinacions.create', compact('subsecciones', 'tipos_refs'));
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
            $request['rango_referencia'] = 'Fem. ' .  $request->rango_referencia_femenino_inferior . '-' . $request->rango_referencia_femenino_superior . ' | Masc. ' .  $request->rango_referencia_masculino_inferior . '-' . $request->rango_referencia_masculino_superior;
            break;
          case 'rango':
            $request['rango_referencia'] = $request->rango_referencia_inferior . '-' . $request->rango_referencia_superior;
            break;
          default:
            $request['rango_referencia'] = strtolower(str_replace(' ', '_', $request->rango_referencia));
            break;
        }
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

        return view('analisis::admin.determinacions.edit', compact('determinacion', 'subsecciones'));
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
        $this->determinacion->destroy($determinacion);

        return redirect()->route('admin.analisis.determinacion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::determinacions.title.determinacions')]));
    }
}
