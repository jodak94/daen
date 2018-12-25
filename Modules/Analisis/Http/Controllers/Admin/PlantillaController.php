<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Plantilla;
use Modules\Analisis\Http\Requests\CreatePlantillaRequest;
use Modules\Analisis\Http\Requests\UpdatePlantillaRequest;
use Modules\Analisis\Repositories\PlantillaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
        //$plantillas = $this->plantilla->all();

        return view('analisis::admin.plantillas.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('analisis::admin.plantillas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlantillaRequest $request
     * @return Response
     */
    public function store(CreatePlantillaRequest $request)
    {
        $this->plantilla->create($request->all());

        return redirect()->route('admin.analisis.plantilla.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::plantillas.title.plantillas')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Plantilla $plantilla
     * @return Response
     */
    public function edit(Plantilla $plantilla)
    {
        return view('analisis::admin.plantillas.edit', compact('plantilla'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Plantilla $plantilla
     * @param  UpdatePlantillaRequest $request
     * @return Response
     */
    public function update(Plantilla $plantilla, UpdatePlantillaRequest $request)
    {
        $this->plantilla->update($plantilla, $request->all());

        return redirect()->route('admin.analisis.plantilla.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::plantillas.title.plantillas')]));
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

        return redirect()->route('admin.analisis.plantilla.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::plantillas.title.plantillas')]));
    }
}
