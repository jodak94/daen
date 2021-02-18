<img src="{{ asset('img/back-preview.jpg')}}"  width="100%"/>
{{-- Cabecera --}}
@include('analisis::pdf.partials.paciente')
{{-- Resultados --}}
@php
  $y = $boxes->titulo_resultado->y;
  $seccion_actual = -1;
  $subseccion_actual = -1;
  $bottom_limit = 21;
@endphp
@foreach ($analisis->resultados as $resultado)
  @if($seccion_actual != $resultado->determinacion->subseccion->seccion->id)
    <div class="{{$action}} @if($seccion_actual != -1) margin-top @endif" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><b>{{$resultado->determinacion->subseccion->seccion->titulo}}</b></div>
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
    <div class="{{$action}} tituloS" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}}</u></div>
    @php
      $y += $y_acu
    @endphp
  @endif
  @php
    $ajuste_x = (strlen($resultado->valor)/2)/10;
  @endphp
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
  @php
    if($resultado->fuera_rango)
      $x_resultado = $boxes->fuera_rango->x;
    else
      $x_resultado = $boxes->resultado->x;

    if($resultado->determinacion->multiples_lineas){
      $x_ajustada = $boxes->titulo_resultado->x + 1;
      $y += $y_acu;
    }else
      $x_ajustada = $x_resultado - $ajuste_x;
  @endphp
  @if($resultado->determinacion->tipo_trato == 'antibiograma')
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x  + 0.4}}cm;top: {{ $y }}cm; font-style: italic">Sensible A:</div>
    @php
      $y += $y_acu;
      $v = explode(':', $resultado->valor);
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
  @else
    <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada}}cm;top: {{ $y }}cm">
      @if($resultado->determinacion->multiples_lineas)
        @php
          $valores = explode('<br />', nl2br($resultado->valor, '\n'));
          foreach ($valores as $value) {
            echo ($value . '<br>');
            $y += $y_acu;
          }
          $y += $y_acu;
        @endphp
      @else
        {{is_numeric($resultado->valor) ? $resultado->valor . ' ' . $resultado->determinacion->unidad_medida : $resultado->valor}}
      @endif
    </div>
  @endif
  @if(isset($resultado->determinacion->texto_ref))
    @if($resultado->trato_especial && $resultado->tipo_trato == 'bgch' && $resultado->valor == 'positivo')
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">Negativo</div>
    @else
      @php
      $lineas = explode('|', $resultado->determinacion->texto_ref);
        foreach ($lineas as $linea) {
          echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.'cm;top:  '.$y.'cm">'.$linea.'</div>');
          $y += $y_acu;
        }
      @endphp
    @endif
  @else
    @if(strpos($resultado->determinacion->rango_referencia_format, '|'))
      @php
        $rangos = explode('|', $resultado->determinacion->rango_referencia_format);
        echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[0] . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '') . '</div>');
        $y += $y_acu;
        echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[1] . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '') . '</div>');
        $y += 0.1;
      @endphp
    @else
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '')}} </div>
    @endif
  @endif
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
@endforeach
