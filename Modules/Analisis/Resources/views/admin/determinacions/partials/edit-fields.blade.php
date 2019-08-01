<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors, $determinacion) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones, $determinacion) !!}
    </div>
    <div class="col-md-4">
      {!! Form:: normalSelect('tipo_referencia', 'Tipo de Rango de referencia', $errors, $tipos_refs, $determinacion) !!}
    </div>
  </div>
  <div class="row" id="rango-titulo-container" @if($determinacion->tipo_referencia == 'sin_referencia') style="display:none"@endif>
    <div class="col-md-9">
      <h3>Rango de Referencia</h3>
    </div>
  </div>
  <div class="row" id="rango-container">
  </div>
</div>
