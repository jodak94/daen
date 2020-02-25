<img src="{{ public_path($analisis->resultados[0]->determinacion->subseccion->seccion->background)}}"  width="100%"/>
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
      <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%"/>
      @php
        $y = $boxes->titulo_resultado->y;
        //$ajuste_y = 0.4; //Posible bug
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
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><b>{{$resultado->determinacion->subseccion->seccion->titulo}} </b></div>
  @endif
  {{-- -------------!SECCIONES-------------- --}}

  {{-- -------------SUBSECCIONES------------- --}}
  @if($subseccion_actual != $resultado->determinacion->subseccion->id && $resultado->mostrar_subtitulo)
    @php
        $y += $y_acu;
    @endphp
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}} </u></div>
    @php
      $y += $y_acu + 0.1
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
  @if($resultado->determinacion->trato_especial)
    @switch($resultado->determinacion->tipo_trato)
      @case ('antibiograma')
        <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x}}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
        @php
          $y += $y_acu
        @endphp
        <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x  + 0.4}}cm;top: {{ $y }}cm; font-style: italic">Sensible A:</div>
        @php
          $y += $y_acu;
          $v = explode(':', $analisis->resultados[9]->valor);
        @endphp
        @foreach (explode(',',rtrim($v[0], ',')) as $sensible)
          <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x + 0.8 }}cm;top: {{ $y }}cm">- {{$sensible}}</div>
          @php
            $y += $y_acu
          @endphp
        @endforeach
        <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x  + 0.4}}cm;top: {{ $y }}cm; font-style: italic">Resistente A:</div>
        @php
          $y += $y_acu
        @endphp
        @foreach (explode(',',rtrim($v[1], ',')) as $resistente)
          <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x + 0.8 }}cm;top: {{ $y }}cm">- {{$resistente}}</div>
          @php
            $y += $y_acu
          @endphp
        @endforeach
      @break
    @endswitch
  @else
    @if($resultado->determinacion->multiples_lineas)
      @php
        $valores = explode('<br />', nl2br($resultado->valor, '\n'));
      @endphp
      @if($y + (count($valores) + 1 ) * $y_acu >= $bottom_limit - 1)
        <div style="page-break-after: always;"></div>
        <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%"/>
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
      @php
        $y += $y_acu
      @endphp
    </div>
    @else
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
      <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada}}cm;top: {{ $y }}cm">
        {{$resultado->valor . ' ' . $resultado->determinacion->unidad_medida}}
      </div>
    @endif
  @endif
  @if(strpos($resultado->determinacion->rango_referencia_format, '|'))
    @php
      $rangos = explode('|', $resultado->determinacion->rango_referencia_format);
      echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[0] . ' ' . $resultado->determinacion->unidad_medida. '-' . $y .'</div>');
      $y += $y_acu;
      echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[1] . ' ' . $resultado->determinacion->unidad_medida. '-' . $y .'</div>');
      $y += 0.1;
    @endphp
  @else
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . $resultado->determinacion->unidad_medida}} </div>
  @endif
  {{-- ------------!RESULTADOS-------------- --}}
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
  @if($y >= $bottom_limit - 1)
    @include('analisis::pdf.partials.paciente')
    <div style="page-break-after: always;"></div>
    <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%"/>
    @php
      $y = $boxes->titulo_resultado->y;
    @endphp
  @endif
@endforeach
