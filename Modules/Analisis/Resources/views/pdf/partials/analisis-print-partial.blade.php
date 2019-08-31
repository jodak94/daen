@include('analisis::pdf.partials.paciente')
@php
  $y = $boxes->titulo_resultado->y;
  $seccion_actual = -1;
  $subseccion_actual = -1;
  $bottom_limit = 25;
@endphp
@foreach ($analisis->resultados as $rkey => $resultado){{--Por cada resultado--}}
  {{-- --------------SECCIONES-------------- --}}
  @if($seccion_actual != $resultado->determinacion->subseccion->seccion->id){{--Si es nueva seccion--}}
    @if($resultado->determinacion->subseccion->seccion->salto_pagina && $rkey != 0){{--Si la seccion va en una pagina aparte--}}
      <div style="page-break-after: always;"></div>
      @php
        $y = $boxes->titulo_resultado->y;
        $ajuste_y = 0.4; //Posible bug
      @endphp
      @include('analisis::pdf.partials.paciente')
    @else
      @php
        $ajuste_y = 0;
      @endphp
    @endif
    @php
      $y += $y_acu + $ajuste_y;
    @endphp
    <div class="{{$action}} @if($seccion_actual != -1) margin-top @endif" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><b>{{$resultado->determinacion->subseccion->seccion->titulo}}</b></div>
    @php
      $y += $y_acu + $ajuste_y;
    @endphp
  @endif
  {{-- -------------!SECCIONES-------------- --}}

  {{-- -------------SUBSECCIONES------------- --}}
  @if($subseccion_actual != $resultado->determinacion->subseccion->id && $resultado->mostrar_subtitulo)
    @php
      if($resultado->determinacion->subseccion->orden > 0)
        $y += $y_acu;
    @endphp  
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}}</u></div>
    @php
      $y += $y_acu
    @endphp
  @endif
  {{-- -------------!SUBSECCIONES------------- --}}

  {{-- -------------RESULTADOS-------------- --}}
  @php
    $ajuste_x = (strlen($resultado->valor)/2)/10;
    if($resultado->fuera_rango)
      $x_resultado = $boxes->fuera_rango->x;
    else
      $x_resultado = $boxes->resultado->x;

    if($resultado->determinacion->multiples_lineas)
      $x_ajustada = $boxes->titulo_resultado->x + 1;
    else
      $x_ajustada = $x_resultado - $ajuste_x;
  @endphp

  @if($resultado->determinacion->multiples_lineas)
    @php
      $valores = explode('<br />', nl2br($resultado->valor, '\n'));
    @endphp
    @if($y + (count($valores) + 1 ) * $y_acu >= $bottom_limit - 1)
      <div style="page-break-after: always;"></div>
      @php
        $y = $boxes->titulo_resultado->y;
      @endphp
      @include('analisis::pdf.partials.paciente')
    @endif
    <div class="{{$action}}" style="position: absolute;left: {{$boxes->titulo_resultado->x}} cm;top: {{$y}}cm">{{$resultado->determinacion->titulo}}</div>
    <div class="{{$action}}" style="position: absolute;left: {{$x_ajustada}} cm;top: {{$y}} cm">
    <br>
    @foreach ($valores as $value)
      {{$value}} <br>
      @php
        $y += $y_acu
      @endphp
    @endforeach
  </div>
  @else
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
    <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada}}cm;top: {{ $y }}cm">
      {{$resultado->valor . ' ' . $resultado->determinacion->unidad_medida}}
    </div>
  @endif
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . $resultado->determinacion->unidad_medida}}</div>
  {{-- ------------!RESULTADOS-------------- --}}
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
  @if($y >= $bottom_limit - 1)
    @include('analisis::pdf.partials.paciente')
    <div style="page-break-after: always;"></div>
    @php
      $y = $boxes->titulo_resultado->y;
    @endphp
  @endif
@endforeach
