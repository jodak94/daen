<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('nombre', 'Nombre', $errors) !!}
    </div>
    <div class="col-md-6">
      {!! Form::normalInput('apellido', 'Apellido', $errors) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('cedula', 'C.I', $errors) !!}
    </div>
    <div class="col-md-6">
      {!! Form:: normalSelect('sexo', 'Sexo', $errors, ['femenino' => 'Femenino', 'masculino' => 'Masculino']) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group ">
        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
        <input class="form-control" placeholder="Fecha de Nacimiento" type="date" name="fecha_nacimiento" id="fecha_nacimiento">
      </div>
    </div>
  </div>
</div>
