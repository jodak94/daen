<div class="box-body">
  <div class="row">
    <div class="col-md-4">
      {!! Form::normalInput('buscar-empresa', 'Empresa', $errors, null) !!}
      <input type="hidden" id="empresa_id" name="empresa_id">
    </div>
    <div class="col-md-4">
      {{ Form::label('fichero', 'Fichero Origen:', ['class' => 'col-sm-4 control-label']) }}
      {{ Form::file('excel', ['class' => 'form-control ','id' => 'file','required' => true]) }}
    </div>
    <div class="col-md-4">
      <label>Columnas: </label> nombre, apellido, cedula, sexo, fecha_nacimiento, empresa.<br>
      <label>Obs: </label> La columna fecha_nacimiento debe ser del tipo texto.
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <button id="btn-subir" type="submit" class="btn btn-primary btn-flat">Subir Archivo</button>
    </div>
  </div>
</div>
