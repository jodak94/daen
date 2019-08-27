<div class="box-body">
  <div class="row">
    <div class="col-md-6">
      {!! Form::normalInput('titulo', 'Título', $errors, null, ['required' => true]) !!}
    </div>
    <div class="col-md-6">
      <label style="color:white">salto</label>
      {!! Form:: normalCheckbox('salto_pagina', 'Salto de página', $errors) !!}
    </div>
  </div>
  <div class="row" id="background-box" style="display:none">
    <div class="col-md-12">
      <label>Seleccionar Fondo</label>
    </div>
    @foreach ($backgrounds as $key => $back)
      <div class="col-md-2">
        <img class="background-option @if($key == 0) selected @endif" src="{{ url($back->file)}}" width="100%" value="{{$back->file}}"/>
      </div>
    @endforeach
    <input type="hidden" name="background" id="background">
  </div>
</div>
