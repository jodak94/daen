<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones) !!}
    </div>
    <div class="col-md-4">
      {!! Form:: normalSelect('tipo_referencia', 'Tipo de Rango de referencia', $errors, $tipos_refs) !!}
    </div>
  </div>
  <div class="row" id="rango-titulo-container">
    <div class="col-md-9">
      <h3>Rango de Referencia</h3>
    </div>
  </div>
  <div class="row" id="rango-container">
    <div class="col-md-2">
      {!! Form::normalInput('rango_referencia_inferior', 'Inferior', $errors) !!}
    </div>
    <div class="col-md-2">
      {!! Form::normalInput('rango_referencia_superior', 'Superior', $errors) !!}
    </div>
    <div class="col-md-2">
      {!! Form::normalInput('unidad_medida', 'Unidad de Medida', $errors) !!}
    </div>
  </div>
</div>
