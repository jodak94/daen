<div class="box-body">
  <div class="row">
    <div class="col-md-3">
      {!! Form::normalInput('titulo', 'Título', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form::normalInput('rangoReferencia', 'Rango de referencia', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form::normalInput('unidadMedida', 'Unidad de Medida', $errors) !!}
    </div>
    <div class="col-md-3">
      {!! Form:: normalSelect('subseccion_id', 'Subsección', $errors, $subsecciones) !!}
    </div>
  </div>
</div>
