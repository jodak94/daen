<img src="{{ public_path($analisis->resultados[0]->determinacion->subseccion->seccion->background)}}" class='img-bg' width="100%"/>
@include('analisis::pdf.partials.paciente')
@php
  $y = $boxes->titulo_resultado->y;
  $seccion_actual = -1;
  $subseccion_actual = -1;
  $bottom_limit = 25.5;
@endphp
@foreach ($analisis->resultados as $rkey => $resultado){{--Por cada resultado--}}
  @php
    if(strpos($resultado->determinacion->titulo, 'SARS-CoV-2'))
        $covid = true;
  @endphp
  {{-- --------------SECCIONES-------------- --}}
  @if($seccion_actual != $resultado->determinacion->subseccion->seccion->id){{--Si es nueva seccion--}}
    @if($resultado->determinacion->subseccion->seccion->salto_pagina && $rkey != 0){{--Si la seccion va en una pagina aparte--}}
      <div style="page-break-after: always;"></div>
      <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%" class='img-bg'/>
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
{{--
    @php  //Pasar toda la sección si una parte pasa a la siguiente hoja
      $ss = array_column(DB::select('SELECT DISTINCT(s.id) FROM analisis__resultados r
      JOIN analisis__determinacions d ON r.determinacion_id = d.id
      JOIN analisis__subseccions s ON d.subseccion_id = s.id
      WHERE analisis_id = '. $analisis->id .' AND s.seccion_id = '. $resultado->determinacion->subseccion->seccion->id), 'id');
      $dc = $analisis->resultados()->whereHas('determinacion' , function($q) use ($ss){
        $q->whereIn('subseccion_id', $ss);
      })->get()->count() + count($ss);

      if((($dc * $y_acu) + $y) >= $bottom_limit - 0.5 && $y > $boxes->titulo_resultado->y)
        $bj = true;
      else
        $bj = false;
    @endphp
    @if($bj)
      <div style="page-break-after: always;"></div>
      @include('analisis::pdf.partials.paciente')
      @php
        $y = $boxes->titulo_resultado->y;
      @endphp
    @endif --}}

    @if($y != $boxes->titulo_resultado->y)
      {{-- @php
      $y += $y_acu + $ajuste_y;
      @endphp --}}
    @endif
    <div class="{{$action}} tituloS" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><b>{{$resultado->determinacion->subseccion->seccion->titulo}} </b></div>
    @php
      $y += $y_acu;
    @endphp
  @endif
  {{-- -------------!SECCIONES-------------- --}}

  {{-- -------------SUBSECCIONES------------- --}}
  @if($subseccion_actual != $resultado->determinacion->subseccion->id && $resultado->mostrar_subtitulo)
    @if($seccion_actual == $resultado->determinacion->subseccion->seccion->id)
      {{-- @php
        $y += $y_acu;
      @endphp --}}
    @endif
    @php
      $dc = $analisis->resultados()->whereHas('determinacion' , function($q) use ($resultado){
        $q->where('subseccion_id', $resultado->determinacion->subseccion->id);
      })->get()->count();

      if($dc < 10 && ($dc * $y_acu) + $y >= $bottom_limit - 0.5 )
        $bj = true;
      else
        $bj = false;
    @endphp
    @if($bj)
      <div style="page-break-after: always;"></div>
      @include('analisis::pdf.partials.paciente')
      @php
        $y = $boxes->titulo_resultado->y;
      @endphp
    @endif
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}}</u></div>
    @php
      $y += $y_acu;
    @endphp
  @endif
  {{-- -------------!SUBSECCIONES------------- --}}

  {{-- -------------RESULTADOS-------------- --}}
  @php
    $ajuste_x = 0;
    if($resultado->fuera_rango)
      $x_resultado = $boxes->fuera_rango->x;
    else
      $x_resultado = $boxes->resultado->x;

    if($resultado->determinacion->multiples_lineas && $resultado->determinacion->tipo_trato != 'multi_select')
      $x_ajustada = $boxes->titulo_resultado->x + 1;
    else
      $x_ajustada = $x_resultado - $ajuste_x;
  @endphp
  @if($resultado->determinacion->tipo_trato == 'antibiograma')
    @if($resultado->determinacion->titulo != '.')
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x}}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
    @endif
    @php
      $y += $y_acu
    @endphp
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
    @if($resultado->determinacion->multiples_lineas)
      @php
        $valores = explode('<br />', nl2br($resultado->valor, '\n'));
      @endphp
      @if($y + (count($valores) + 1 ) * $y_acu >= $bottom_limit - 0.5)
        <div style="page-break-after: always;"></div>
        <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%" class='img-bg'/>
        @php
          $y = $boxes->titulo_resultado->y;
        @endphp
        @include('analisis::pdf.partials.paciente')
      @endif
      @if($resultado->determinacion->titulo != '.')
        <div class="{{$action}}" style="position: absolute;left: {{$boxes->titulo_resultado->x}} cm;top: {{$y}}cm">{{$resultado->determinacion->titulo}}</div>
      @endif
      <div class="{{$action}}" style="position: absolute;left: {{$x_ajustada}} cm;top: {{$y}} cm">
      @if($resultado->determinacion->tipo_trato != 'multi_select')
        <br>
      @endif
      @foreach ($valores as $value)
        @php
          echo($value . " <br>");
          $y += $y_acu
        @endphp
      @endforeach
      @php
        if($resultado->determinacion->tipo_trato == 'multi_select')
          $y -= $y_acu;
        // else {
          // $y += $y_acu;
        // }
      @endphp
    </div>
    @else
      @if($resultado->determinacion->titulo != '.')
        <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
      @endif
      <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada}}cm;top: {{ $y }}cm">
        @if($resultado->valor != '.')
          {{is_numeric(str_replace (',', '', $resultado->valor)) ? $resultado->valor . ' ' . $resultado->determinacion->unidad_medida : $resultado->valor}}
        @endif
      </div>
    @endif
  @endif
  @if(isset($resultado->determinacion->texto_ref))
    @if($resultado->trato_especial && $resultado->tipo_trato == 'bgch' && $resultado->valor == 'positivo')
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">Negativo</div>
    @else
      @php
      $lineas = explode('|', $resultado->determinacion->texto_ref);
        foreach ($lineas as $linea) {
          echo ('<div class="'.$action.' texto-ref" style="position: absolute;left: '.$boxes->rango_referencia->x.'cm;top: '.$y.'cm">'.$linea.'</div>');
          $y += $y_acu;
        }
        $y -= $y_acu;
      @endphp
    @endif
  @else
    @if($resultado->determinacion->tipo_referencia == 'rango_sexo' || $resultado->determinacion->tipo_referencia == 'rango_edad')
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->getRangoReferenciaFormatAttributeSexoEdad($analisis->paciente) . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '')}}</div
    @elseif(strpos($resultado->determinacion->rango_referencia_format, '|'))
      @php
        $rangos = explode('|', $resultado->determinacion->rango_referencia_format);
        echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[0] . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '') . '</div>');
        $y += $y_acu;
        echo ('<div class="'.$action.'" style="position: absolute;left:  '.$boxes->rango_referencia->x.' cm;top:  '.$y.' cm">'.$rangos[1] . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '') .'</div>');
        $y += 0.1;
      @endphp
    @else
      <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . (isset($resultado->determinacion->rango_referencia) ? $resultado->determinacion->unidad_medida : '')}} </div>
    @endif
  @endif
  {{-- ------------!RESULTADOS-------------- --}}
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
  @if($y >= $bottom_limit - 0.5 && $rkey < count($analisis->resultados) - 1)
    <div style="page-break-after: always;"></div>
    <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%" class='img-bg'/>
    @include('analisis::pdf.partials.paciente')
    @php
      $y = $boxes->titulo_resultado->y;
    @endphp
  @endif
@endforeach
@if(isset($covid) && $covid)
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x}}cm;top: {{ $bottom_limit }}cm; font-size:10px">
    *Las muestras son derivadas y procesadas en ORTEGABIOLAB en convenio con DAEN lab, autorizado
    por la Dirección de Registro, Habilitación y Control - LCSP.<br>
    * The samples are derived and processed in ORTEGABIOLAB in an agreement with DAEN lab, authorized
    by the Directorate of Registration, Authorization and Control - LCSP.
  </div>
@endif
{{-- Firma --}}
@if($y >= $bottom_limit - 2.5 && $rkey < count($analisis->resultados) - 1)
  <div style="page-break-after: always;"></div>
  <img src="{{ public_path($resultado->determinacion->subseccion->seccion->background)}}"  width="100%" class='img-bg'/>
  @include('analisis::pdf.partials.paciente')
  @php
    $y = $boxes->titulo_resultado->y + 2;
  @endphp
@else
  @php
    $y = $y + 1;
  @endphp
@endif
@php
if($analisis->firma == 'lujan'){
  $img = '/img/firma_lujan_t.png';
  $sello1 = 'Bioq. Ma. Luján Enciso Dacak';
  $sello2 = 'Reg. Prof. Nº 2600';
  $x2 = $x2 = $boxes->rango_referencia->x + 0.8;
  $y2 = 1.6;
}
if($analisis->firma == 'margarita'){
  $img = '/img/firma_ma_t.png';
  $sello1 = 'Dra. Margarita Dacak';
  $sello2 = 'Reg. Prof. Nº 2600';
  $x2 = $boxes->rango_referencia->x + 0.2;
  $y2 = 1.2;
}
@endphp
<div style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">
  <img src="{{ public_path($img)}}" class='firma' width="100px"/>
</div>
@php
  $y = $y + $y_acu + $y2;
@endphp
<div class="sello" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">
  <b>{{$sello1}}</b>
</div>
@php
  $y += 0.4;
@endphp
<div class="sello" style="position: absolute;left: {{ $x2}}cm;top: {{ $y }}cm">
  <b>{{$sello2}}</b>
</div>
