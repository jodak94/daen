<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Analisis;
use Modules\Analisis\Http\Requests\CreateAnalisisRequest;
use Modules\Analisis\Http\Requests\UpdateAnalisisRequest;
use Modules\Analisis\Repositories\AnalisisRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
        //$analises = $this->analisis->all();

        return view('analisis::admin.analises.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('analisis::admin.analises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAnalisisRequest $request
     * @return Response
     */
    public function store(CreateAnalisisRequest $request)
    {
        $this->analisis->create($request->all());

        return redirect()->route('admin.analisis.analisis.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::analises.title.analises')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Analisis $analisis
     * @return Response
     */
    public function edit(Analisis $analisis)
    {
        return view('analisis::admin.analises.edit', compact('analisis'));
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
