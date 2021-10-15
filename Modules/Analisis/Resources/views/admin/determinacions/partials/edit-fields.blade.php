<div class="box-body">
  <div class="row">
    <div class="col-md-2">
      {!! Form::normalInput('titulo', 'Título', $errors, $determinacion) !!}
    </div>
    <div class="col-md-2">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones, $determinacion) !!}
    </div>
    <div class="col-md-2">
      {!! Form:: normalSelect('tipo_referencia', 'Tipo de Rango de referencia', $errors, $tipos_refs, $determinacion) !!}
    </div>
    <div class="col-md-2">
      {!! Form::normalInput('unidad_medida', 'Unidad de Medida', $errors, $determinacion) !!}
    </div>
    <div class="col-md-2">
      {!! Form::normalInput('cantidad_decimales', 'Cantidad de decimales', $errors, $determinacion) !!}
    </div>
    <div class="col-md-2">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('multiples_lineas', 'Varias lineas', $errors, $determinacion) !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-5">
      <label>Texto Referencia</label>
      <textarea name="texto_ref" class='form-control valor' rows='5'>{{$determinacion->texto_ref}}</textarea>
    </div>
    <div class="col-md-5">
      <label>Texto Por Defecto</label>
      <textarea name="texto_por_defecto" class='form-control valor' rows='5'>{{$determinacion->texto_por_defecto}}</textarea>
    </div>
    <div class="col-md-2">
      <label>Obs.</label><br>
      <ul>
        <li>{{'<i>'}} = cursiva</xmp></li>
        <li>{{'<b>'}} = negrita</li>
        <li>{{'<u>'}} = subrayado</li>
        <li>Para delimitar usar {{'</i>'}}</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <label style="color:white">lineas</label>
      {!! Form:: normalCheckbox('trato_especial', 'Trato Especial', $errors, $determinacion) !!}
    </div>
    <div class="col-md-3 tipo_trato_container" @if(!$determinacion->trato_especial) style="display:none" @endif>
      {!! Form:: normalSelect('tipo_trato', 'Tipo trato', $errors, $tipos_tratos, $determinacion) !!}
    </div>
    <div class="col-md-5 tipo_trato_container" @if(!$determinacion->trato_especial) style="display:none" @endif>
      <label>Texto H</label>
      <textarea name="texto_h" class='form-control valor' rows='5'>{{$determinacion->texto_h}}</textarea>
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
