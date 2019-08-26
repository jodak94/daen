<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('titulo', 'Título', $errors, $seccion) !!}
    </div>
    <div class="col-md-6">
      <label style="color:white">salto</label>
      {!! Form:: normalCheckbox('salto_pagina', 'Salto de página', $errors, $seccion) !!}
    </div>
  </div>
</div>
