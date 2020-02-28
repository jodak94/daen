<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('seccion_id', 'Sección', $errors, $secciones) !!}
    </div>
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('mostrar', 'Mostrar Título', $errors) !!}
    </div>
  </div>
</div>
