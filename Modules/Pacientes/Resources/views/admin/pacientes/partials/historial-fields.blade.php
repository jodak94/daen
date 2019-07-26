<div class="box-body">
  <div class="row">
    <div class="col-md-4">
      <div class="col-md-12">
        {!! Form::normalInput('nombre', 'Nombre', $errors, $paciente, ['disabled' => true], ['disabled' => true]) !!}
      </div>
      <div class="col-md-12">
        {!! Form::normalInput('apellido', 'Apellido', $errors, $paciente, ['disabled' => true]) !!}
      </div>
      <div class="col-md-12">
        {!! Form::normalInput('cedula', 'C.I', $errors, $paciente, ['disabled' => true]) !!}
      </div>
      <div class="col-md-12">
        {!! Form:: normalInput('sexo', 'Sexo', $errors, $paciente, ['disabled' => true]) !!}
      </div>
      <div class="col-md-12">
        {!! Form:: normalInput('edad', 'Edad', $errors, $paciente, ['disabled' => true]) !!}
      </div>
    </div>
  </div>
</div>
