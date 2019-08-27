@if($action == 'preview')
  <img src="{{ asset('img/back-preview.jpg')}}"  width="100%"/>
@endif
@if($action == 'download')
    @if(isset($analisis->resultados[0]->determinacion->subseccion->seccion->background))
      <img src="{{ public_path($analisis->resultados[0]->determinacion->subseccion->seccion->background)}}" width="100%" style="margin: auto;"/>
    @else
      <img src="{{ public_path('img/back-resultado-1.jpg')}}" width="100%" style="margin: auto;"/>
    @endif
@endif
{{-- Cabecera --}}
@include('analisis::pdf.partials.paciente')
{{-- Resultados --}}
@php
  $y = $boxes->titulo_resultado->y;
  $seccion_actual = -1;
  $subseccion_actual = -1;
  $page_number = 0;
  $bottom_limit = 21;
@endphp
@foreach ($analisis->resultados as $resultado)
  @if($seccion_actual != $resultado->determinacion->subseccion->seccion->id)
    @if($resultado->determinacion->subseccion->seccion->salto_pagina && $page_number != 0)
      <div style="page-break-after: always;"></div>
      <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}" width="100%" style="margin: auto;"/>
      @php
          $y = $boxes->titulo_resultado->y;
      @endphp
      @include('analisis::pdf.partials.paciente')
    @endif
    @php
      $page_number++;
    @endphp
    @if($y + $y_acu + 1.4 >= 21)
      <div style="page-break-after: always;"></div>
      @if($action == 'download')
          <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}" width="100%" style="margin: auto;"/>
      @endif
      @php
        if($action != 'preview')
          $y = $boxes->titulo_resultado->y;
      @endphp
    @endif
    <div class="{{$action}} @if($seccion_actual != -1) margin-top @endif" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><b>{{$resultado->determinacion->subseccion->seccion->titulo}} - {{$y}}</b></div>
    @php
      if($seccion_actual != -1)
        $y += $y_acu + 0.4;
      else
        $y += $y_acu;
    @endphp
    @if($seccion_actual != -1)
      <br>
    @endif
  @endif
  @if($subseccion_actual != $resultado->determinacion->subseccion->id && $resultado->mostrar_subtitulo)
    @if($y + $y_acu >= 21)
      <div style="page-break-after: always;"></div>
      @if($action == 'download')
          <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}" width="100%" style="margin: auto;"/>
      @endif
      @php
        if($action != 'preview')
          $y = $boxes->titulo_resultado->y;
      @endphp
    @endif
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}} - {{$y}}</u></div>
    @php
      $y += $y_acu
    @endphp
  @endif
  @php
    $ajuste_x = (strlen($resultado->valor)/2)/10;
  @endphp
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}} - {{$y}}</div>
  @php
    if($resultado->fuera_rango)
      $x_resultado = $boxes->fuera_rango->x;
    else
      $x_resultado = $boxes->titulo_resultado->x;

    if($resultado->determinacion->multiples_lineas){
      $x_ajustada = $boxes->titulo_resultado->x + 1;
      $y += $y_acu;
    }else
      $x_ajustada = $x_resultado - $ajuste_x;
  @endphp
  <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada}}cm;top: {{ $y }}cm">
    @if($resultado->determinacion->multiples_lineas)
      @php
        $valores = explode('<br />', nl2br($analisis->resultados[0]->valor, '\n'));
        foreach ($valores as $value) {
          echo ($value . '<br>');
          $y += $y_acu;
        }
        $y += $y_acu;
      @endphp
    @else
      {{$resultado->valor . ' ' . $resultado->determinacion->unidad_medida}}
    @endif
  </div>
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . $resultado->determinacion->unidad_medida}}</div>
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
  @if($y >= 21 )
    <div style="page-break-after: always;"></div>
    @if($action == 'download')
        <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}" width="100%" style="margin: auto"/>
    @endif
    @php
      if($action != 'preview')
        $y = $boxes->titulo_resultado->y;
    @endphp
    @include('analisis::pdf.partials.paciente')
  @endif
@endforeach
