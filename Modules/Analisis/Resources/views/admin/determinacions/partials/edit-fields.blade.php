<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors, $determinacion) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones, $determinacion) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('tipo_referencia', 'Tipo de Rango de referencia', $errors, $tipos_refs, $determinacion) !!}
    </div>
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('multiples_lineas', 'Varias lineas', $errors, $determinacion) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('trato_especial', 'Trato Especial', $errors, $determinacion) !!}
    </div>
    <div class="col-md-3" @if(!$determinacion->trato_especial) style="display:none" @endif id="tipo_trato_container">
      {!! Form:: normalSelect('tipo_trato', 'Tipo trato', $errors, [null => '--', 'antibiograma' => 'Antibiograma'], $determinacion) !!}
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
