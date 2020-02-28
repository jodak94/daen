<div class="box-body">
  <div class="row">
    <div class="col-md-4">
      {!! Form::normalInput('titulo', 'Título', $errors, $subseccion) !!}
    </div>
    <div class="col-md-4">
      {!! Form:: normalSelect('seccion_id', 'Sección', $errors, $secciones, $subseccion) !!}
    </div>
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('mostrar', 'Mostrar Título', $errors, $subseccion) !!}
    </div>
  </div>
</div>
