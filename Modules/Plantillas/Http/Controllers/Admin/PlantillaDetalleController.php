<?php

namespace Modules\Plantillas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Plantillas\Entities\PlantillaDetalle;
use Modules\Plantillas\Http\Requests\CreatePlantillaDetalleRequest;
use Modules\Plantillas\Http\Requests\UpdatePlantillaDetalleRequest;
use Modules\Plantillas\Repositories\PlantillaDetalleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PlantillaDetalleController extends AdminBaseController
{
    /**
     * @var PlantillaDetalleRepository
     */
    private $plantilladetalle;

    public function __construct(PlantillaDetalleRepository $plantilladetalle)
    {
        parent::__construct();

        $this->plantilladetalle = $plantilladetalle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$plantilladetalles = $this->plantilladetalle->all();

        return view('plantillas::admin.plantilladetalles.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('plantillas::admin.plantilladetalles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePlantillaDetalleRequest $request
     * @return Response
     */
    public function store(CreatePlantillaDetalleRequest $request)
    {
        $this->plantilladetalle->create($request->all());

        return redirect()->route('admin.plantillas.plantilladetalle.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('plantillas::plantilladetalles.title.plantilladetalles')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PlantillaDetalle $plantilladetalle
     * @return Response
     */
    public function edit(PlantillaDetalle $plantilladetalle)
    {
        return view('plantillas::admin.plantilladetalles.edit', compact('plantilladetalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlantillaDetalle $plantilladetalle
     * @param  UpdatePlantillaDetalleRequest $request
     * @return Response
     */
    public function update(PlantillaDetalle $plantilladetalle, UpdatePlantillaDetalleRequest $request)
    {
        $this->plantilladetalle->update($plantilladetalle, $request->all());

        return redirect()->route('admin.plantillas.plantilladetalle.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('plantillas::plantilladetalles.title.plantilladetalles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PlantillaDetalle $plantilladetalle
     * @return Response
     */
    public function destroy(PlantillaDetalle $plantilladetalle)
    {
        $this->plantilladetalle->destroy($plantilladetalle);

        return redirect()->route('admin.plantillas.plantilladetalle.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('plantillas::plantilladetalles.title.plantilladetalles')]));
    }
}
