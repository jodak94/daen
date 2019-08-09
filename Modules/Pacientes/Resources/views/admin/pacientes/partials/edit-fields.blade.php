<style>
  .fa-times:hover{
    cursor: pointer;
  }
</style>
<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('nombre', 'Nombre', $errors, $paciente, ['required' => true]) !!}
    </div>
    <div class="col-md-6">
      {!! Form::normalInput('apellido', 'Apellido', $errors , $paciente, ['required' => true]) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('cedula', 'C.I', $errors , $paciente, ['required' => true]) !!}
    </div>
    <div class="col-md-6">
      {!! Form:: normalSelect('sexo', 'Sexo', $errors, ['femenino' => 'Femenino', 'masculino' => 'Masculino'], $paciente) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group ">
        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
        <input class="form-control" placeholder="Fecha de Nacimiento" type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{$paciente->fecha_nacimiento}}" required>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('buscar-empresa', 'Empresa', $errors, (Object)["buscar-empresa" => $paciente->empresa_format]) !!}
      <input type="hidden" id="empresa_id" name="empresa_id" value="{{$paciente->empresa_id}}">
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label style="color: white">x</label><br>
        <span class="label label-success" @if(!isset($paciente->empresa_id)) style="display:none" @endif id="box-empresa"><span id="nombre-empresa">{{$paciente->empresa_format}}</span>
          <i class="fa fa-times" id="eliminar-empresa" aria-hidden="true"></i>
        </span>
      </div>
    </div>
  </div>
</div>
