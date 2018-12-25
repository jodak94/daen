<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Seccion;
use Modules\Analisis\Http\Requests\CreateSeccionRequest;
use Modules\Analisis\Http\Requests\UpdateSeccionRequest;
use Modules\Analisis\Repositories\SeccionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
        //$seccions = $this->seccion->all();

        return view('analisis::admin.seccions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('analisis::admin.seccions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSeccionRequest $request
     * @return Response
     */
    public function store(CreateSeccionRequest $request)
    {
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
        $this->seccion->destroy($seccion);

        return redirect()->route('admin.analisis.seccion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::seccions.title.seccions')]));
    }
}
