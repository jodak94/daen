<?php

namespace Modules\Pacientes\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Pacientes\Entities\Paciente;
use Modules\Pacientes\Http\Requests\CreatePacienteRequest;
use Modules\Pacientes\Http\Requests\UpdatePacienteRequest;
use Modules\Pacientes\Repositories\PacienteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\DataTables\Facades\DataTables;
use Log;
use DB;
use \Excel;
use App\Imports\PacientesImport;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
class PacienteController extends AdminBaseController
{
    /**
     * @var PacienteRepository
     */
    private $paciente;
    private $rules;
    private $messages;

    public function __construct(PacienteRepository $paciente)
    {
        parent::__construct();

        $this->paciente = $paciente;

        $this->rules = [
            'nombre'  => 'required',
            'apellido' => 'required',
            'cedula' => 'numeric|required|unique:pacientes__pacientes',
            'sexo'     => 'required|in:masculino,femenino',
        ];
        $this->messages = [
            'required'    => 'El campo :attribute no puede quedar vacio.',
            'unique' => 'El campo :attribute debe ser único. Ya existe ese valor.',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('pacientes::admin.pacientes.index');
    }

    public function index_ajax(Request $re){
      $query = $this->query_index_ajax($re);
      $object = Datatables::of($query)
          ->addColumn('acciones', function( $paciente ){
            $edit_route = route('admin.pacientes.paciente.edit', $paciente->id);
            $delete_route = route('admin.pacientes.paciente.destroy', $paciente->id);
            $html = '
              <div class="btn-group">
                <button title="Historial" paciente="'.$paciente->id.'"  class="btn btn-default btn-flat historial"><i class="fa fa-file-text-o"></i></button>
                <a href="'.$edit_route.'" class="preview btn btn-default btn-flat" title="Editar">
                  <i class="fa fa-pencil"></i>
                </a>
                <button class="btn btn-danger btn-flat" title="Eliminar" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'.$delete_route.'">
                  <i class="fa fa-trash"></i>
                  </button>
              </div>';

            return $html;
          })
          ->rawColumns(['acciones'])
          ->make(true);
      $data = $object->getData(true);
      return response()->json( $data );
    }

    public function query_index_ajax($re){
      $query = Paciente::select();
      if (isset($re->paciente) && trim($re->paciente) != '')
        $query->where(DB::raw("CONCAT(nombre, ' ', apellido)"), 'like',  '%' . $re->paciente . '%')
         ->orWhere('cedula', 'like', '%' . $re->paciente . '%');

       return $query;
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
      $paciente->empresa_id = $request->empresa_id;
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
            ->withSuccess('Paciente eliminado exitosamente');
    }

    public function get_analisis_id(Request $request){
      $paciente = Paciente::find($request->paciente_id);
      if(!isset($paciente))
        return response()->json(['error' => true]);

      $resultados = $paciente->analisis()->get()->pluck('id');

      return response()->json(['error' => false, 'resultados' => $resultados]);
    }

    public function get_importar(){
      return view('pacientes::admin.pacientes.import');
    }

    public function post_importar(Request $request){
      $result = array($request->file('excel')->getClientOriginalExtension());
      $extensions = array("xls","xlsx");
      if(in_array($result[0],$extensions)){
        DB::beginTransaction();
        try{
          $rows = Excel::toArray(new PacientesImport, request()->file('excel'));
          $errors = [];
          $pacientes_error = [];
          $pacientes_cargados = 0;
          $c = 0;
          foreach($rows as $row) {
            foreach($row as $paciente) {
              $c++;
              if($paciente["sexo"] == 'm' || $paciente["sexo"] == 'masc')
                $paciente["sexo"] = 'masculino';
              elseif ($paciente["sexo"] == 'f' || $paciente["sexo"] == 'fem')
                $paciente["sexo"] = 'femenino';
              else
                $paciente["sexo"] == strtolower($paciente["sexo"]);
              $error = $this->cell_validation($paciente, $this->rules);
              if (!empty($error)) {
                $errors[] = $error;
                $pacientes_error[] = $paciente;
              }else {
                Log::info($paciente["sexo"]);
                $nuevo_paciente = new Paciente();
                $nuevo_paciente->nombre = $paciente["nombre"];
                $nuevo_paciente->apellido = $paciente["apellido"];
                $nuevo_paciente->sexo = $paciente["sexo"];
                $nuevo_paciente->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $paciente['fecha_nacimiento']);
                $nuevo_paciente->cedula = $paciente["cedula"];
                $nuevo_paciente->empresa_id = $request->empresa_id;
                $nuevo_paciente->save();
                $pacientes_cargados++;
              }
            }
          }
          DB::commit();
          return response()->json([
              "cargados" => $pacientes_cargados,
              "pacientes" => $pacientes_error,
              "errores" => $errors
          ]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
              "error" => $e,
            ],400);
        }
      }else{
          return response()->json([
              "error" => "error en tipo de archivo",
          ],400);
      }
    }

    public function validation(Request $request) {
      $error = $this->cell_validation($request->paciente, $this->rules);
      if (!empty($error))
          return response()->json(['status' => false, 'error' => $error[0]] ,400);
      return response()->json(['status' => true]);
    }

    private function cell_validation(array $data, array $rules){
        $validator = \Validator::make($data, $this->rules,$this->messages);
        $errors = [];
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();
            foreach ($errorMessages as $key => $value) {
                $error[$key] = $value[0];
            }
            $errors[] = $error;
        }
        try {
          Carbon::createFromFormat('d/m/Y', $data['fecha_nacimiento']);
        } catch (\Exception $e) {
          $errors[0]['fecha_nacimiento'] = 'Fecha de nacimiento invalida';
        }

        return $errors;
    }

    public function store_massive_ajax(Request $request){
      $pacientes_cargados = 0;
      foreach($request->pacientes as $req) {
        if($req != null){
          $paciente = new Paciente();
          $paciente->nombre = $req["nombre"];
          $paciente->apellido = $req["apellido"];
          $paciente->cedula = $req["cedula"];
          $paciente->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $req['fecha_nacimiento']);
          $paciente->sexo = $req["sexo"];
          $paciente->empresa_id = $request->empresa_id;
          $paciente->save();
          $pacientes_cargados++;
        }
      }
      $request->session()->flash('message', 'Nuevos Pacientes agregados.');
      $request->session()->flash('message-type', 'success');
      return response()->json(['cargados'=>$pacientes_cargados]);
    }
}
