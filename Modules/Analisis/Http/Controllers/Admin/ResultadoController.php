<?php

namespace Modules\Analisis\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Analisis\Entities\Resultado;
use Modules\Analisis\Http\Requests\CreateResultadoRequest;
use Modules\Analisis\Http\Requests\UpdateResultadoRequest;
use Modules\Analisis\Repositories\ResultadoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ResultadoController extends AdminBaseController
{
    /**
     * @var ResultadoRepository
     */
    private $resultado;

    public function __construct(ResultadoRepository $resultado)
    {
        parent::__construct();

        $this->resultado = $resultado;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$resultados = $this->resultado->all();
        
        return view('analisis::admin.resultados.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        foreach ($variable as $key => $value) {
          // code...
        }
        return view('analisis::admin.resultados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateResultadoRequest $request
     * @return Response
     */
    public function store(CreateResultadoRequest $request)
    {
        $this->resultado->create($request->all());

        return redirect()->route('admin.analisis.resultado.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('analisis::resultados.title.resultados')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Resultado $resultado
     * @return Response
     */
    public function edit(Resultado $resultado)
    {
        return view('analisis::admin.resultados.edit', compact('resultado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Resultado $resultado
     * @param  UpdateResultadoRequest $request
     * @return Response
     */
    public function update(Resultado $resultado, UpdateResultadoRequest $request)
    {
        $this->resultado->update($resultado, $request->all());

        return redirect()->route('admin.analisis.resultado.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('analisis::resultados.title.resultados')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Resultado $resultado
     * @return Response
     */
    public function destroy(Resultado $resultado)
    {
        $this->resultado->destroy($resultado);

        return redirect()->route('admin.analisis.resultado.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('analisis::resultados.title.resultados')]));
    }
}
