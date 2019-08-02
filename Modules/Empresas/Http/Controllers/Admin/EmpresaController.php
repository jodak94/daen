<?php

namespace Modules\Empresas\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Empresas\Entities\Empresa;
use Modules\Empresas\Http\Requests\CreateEmpresaRequest;
use Modules\Empresas\Http\Requests\UpdateEmpresaRequest;
use Modules\Empresas\Repositories\EmpresaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class EmpresaController extends AdminBaseController
{
    /**
     * @var EmpresaRepository
     */
    private $empresa;

    public function __construct(EmpresaRepository $empresa)
    {
        parent::__construct();

        $this->empresa = $empresa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $empresas = $this->empresa->all();

        return view('empresas::admin.empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('empresas::admin.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEmpresaRequest $request
     * @return Response
     */
    public function store(CreateEmpresaRequest $request)
    {
        $this->empresa->create($request->all());

        return redirect()->route('admin.empresas.empresa.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('empresas::empresas.title.empresas')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Empresa $empresa
     * @return Response
     */
    public function edit(Empresa $empresa)
    {
        return view('empresas::admin.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Empresa $empresa
     * @param  UpdateEmpresaRequest $request
     * @return Response
     */
    public function update(Empresa $empresa, UpdateEmpresaRequest $request)
    {
        $this->empresa->update($empresa, $request->all());

        return redirect()->route('admin.empresas.empresa.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('empresas::empresas.title.empresas')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Empresa $empresa
     * @return Response
     */
    public function destroy(Empresa $empresa)
    {
        $this->empresa->destroy($empresa);

        return redirect()->route('admin.empresas.empresa.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('empresas::empresas.title.empresas')]));
    }

    public function search_ajax(Request $re){
      $empresas = Empresa::where('nombre','like',  '%' . $re->term . '%')
                          ->take(5)
                          ->get(['id', 'nombre AS value']);

      return response()->json($empresas);
    }
}
