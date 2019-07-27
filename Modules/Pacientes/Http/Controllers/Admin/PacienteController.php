<?php

namespace Modules\Pacientes\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pacientes\Entities\Paciente;
use Modules\Pacientes\Http\Requests\CreatePacienteRequest;
use Modules\Pacientes\Http\Requests\UpdatePacienteRequest;
use Modules\Pacientes\Repositories\PacienteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Log;

class PacienteController extends AdminBaseController
{
    /**
     * @var PacienteRepository
     */
    private $paciente;

    public function __construct(PacienteRepository $paciente)
    {
        parent::__construct();

        $this->paciente = $paciente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pacientes = $this->paciente->all();

        return view('pacientes::admin.pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pacientes::admin.pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePacienteRequest $request
     * @return Response
     */
    public function store(CreatePacienteRequest $request)
    {
        $this->paciente->create($request->all());

        return redirect()->route('admin.pacientes.paciente.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('pacientes::pacientes.title.pacientes')]));
    }

    public function store_ajax(Request $request){
      if(count(Paciente::where('cedula', $request->cedula)->get()))
        return response()->json(['error' => true, 'message' => 'Ya existe un paciente con esa cedula']);
      $paciente = new Paciente();
      $paciente->nombre = $request->nombre;
      $paciente->apellido = $request->apellido;
      $paciente->fecha_nacimiento = $request->fecha_nacimiento;
      $paciente->sexo = $request->sexo;
      $paciente->cedula = $request->cedula;
      $paciente->save();
      return response()->json(['error' => false, 'paciente' => $paciente]);
    }

    public function search_ajax(Request $re){
      $re['term_explode'] = explode(' ',$re->term);
      $query_pacientes = Paciente::Where('cedula','like',  '%' . $re->term . '%');
      if (count($re->term_explode) == 1) {
        $query_pacientes->orWhere('nombre','like',  '%' . $re->term_explode[0] . '%')
                        ->orWhere('apellido','like',  '%' . $re->term_explode[0] . '%');
      }else{
        $query_pacientes->orWhere(function ($q) use ($re) {
          $q->where(function ($q) use ($re) {
            foreach ($re->term_explode as $value) {
              $q->orWhere('nombre','like',  '%' . $value . '%');
            }
          });
          $q->where(function ($q) use ($re) {
            foreach ($re->term_explode as $value) {
              $q->orWhere('apellido','like',  '%' . $value . '%');
            }
          });
        });
      }
      $pacientes = $query_pacientes->take(5)->get();
      $results = [];
      foreach ($pacientes as $q){
        $results[] =
        [
          'id' => $q->id,
          'value' => $q->nombre . ' ' .$q->apellido.'. CI: ' . $q->cedula,
          'paciente' => $q,
        ];
      }
      return response()->json($results);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Paciente $paciente
     * @return Response
     */
    public function edit(Paciente $paciente)
    {
        return view('pacientes::admin.pacientes.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Paciente $paciente
     * @param  UpdatePacienteRequest $request
     * @return Response
     */
    public function update(Paciente $paciente, UpdatePacienteRequest $request)
    {
        $this->paciente->update($paciente, $request->all());

        return redirect()->route('admin.pacientes.paciente.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('pacientes::pacientes.title.pacientes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Paciente $paciente
     * @return Response
     */
    public function destroy(Paciente $paciente)
    {
        $this->paciente->destroy($paciente);

        return redirect()->route('admin.pacientes.paciente.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('pacientes::pacientes.title.pacientes')]));
    }

    public function get_analisis_id(Request $request){
      $paciente = Paciente::find($request->paciente_id);
      if(!isset($paciente))
        return response()->json(['error' => true]);

      $resultados = $paciente->analisis()->get()->pluck('id');

      return response()->json(['error' => false, 'resultados' => $resultados]);
    }
}
