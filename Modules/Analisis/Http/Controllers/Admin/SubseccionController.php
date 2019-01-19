<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Subseccion;
use Modules\Analisis\Http\Requests\CreateSubseccionRequest;
use Modules\Analisis\Http\Requests\UpdateSubseccionRequest;
use Modules\Analisis\Repositories\SubseccionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
        //$subseccions = $this->subseccion->all();

        return view('analisis::admin.subseccions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('analisis::admin.subseccions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSubseccionRequest $request
     * @return Response
     */
    public function store(CreateSubseccionRequest $request)
    {
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
        return view('analisis::admin.subseccions.edit', compact('subseccion'));
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
        $this->subseccion->destroy($subseccion);

        return redirect()->route('admin.analisis.subseccion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::subseccions.title.subseccions')]));
    }
}
