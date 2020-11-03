<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('tipo_referencia', 'Tipo de Rango de referencia', $errors, $tipos_refs) !!}
    </div>
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('multiples_lineas', 'Varias lineas', $errors) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <label>Texto Referencia</label>
      <textarea name="texto_ref" class='form-control valor' rows='5'></textarea>
    </div>
    <div class="col-md-3">
      {!! Form::normalInput('unidad_medida', 'Unidad de Medida', $errors) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('trato_especial', 'Trato Especial', $errors) !!}
    </div>
    <div class="col-md-3 tipo_trato_container" style="display:none">
      {!! Form:: normalSelect('tipo_trato', 'Tipo trato', $errors, $tipos_tratos) !!}
    </div>
    <div class="col-md-6 tipo_trato_container" style="display:none">
      <label>Texto H</label>
      <textarea name="texto_h" class='form-control valor' rows='5'></textarea>
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
  </div>
</div>
