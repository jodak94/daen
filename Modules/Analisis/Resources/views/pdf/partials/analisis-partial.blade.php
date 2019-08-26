{{-- Cabecera --}}
<div class="{{$action}}" id="cedula_paciente" style="position: absolute;left: {{ $boxes->cedula_paciente->x }}cm;top: {{ $boxes->cedula_paciente->y }}cm"><b>Paciente: </b>{{$analisis->paciente->cedula_format}}</div>
<div class="{{$action}}" id="nombre_paciente" style="position: absolute;left: {{ $boxes->nombre_paciente->x }}cm;top: {{ $boxes->nombre_paciente->y }}cm"><b>Nombre: </b>{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido}}</div>
<div class="{{$action}}" id="edad_paciente" style="position: absolute;left: {{ $boxes->edad_paciente->x }}cm;top: {{ $boxes->edad_paciente->y }}cm"><b>Edad: </b>{{$analisis->paciente->edad . ' años'}}</div>
<div class="{{$action}}" id="sexo_paciente" style="position: absolute;left: {{ $boxes->sexo_paciente->x }}cm;top: {{ $boxes->sexo_paciente->y }}cm"><b>Sexo: </b>{{ucfirst($analisis->paciente->sexo)}}</div>
<div class="{{$action}}" id="fecha" style="position: absolute;left: {{ $boxes->fecha->x }}cm;top: {{ $boxes->fecha->y }}cm"><b>Fecha: </b>{{Carbon\Carbon::parse($analisis->created_at)->format('d/m/Y')}}</div>

{{-- Resultados --}}
@php
  $y = $boxes->titulo_resultado->y;
  $seccion_actual = -1;
  $subseccion_actual = -1;
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
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm"><u>{{$resultado->determinacion->subseccion->titulo}}</u></div>
    @php
      $y += $y_acu
    @endphp
  @endif
  @php
    $ajuste_x = (strlen($resultado->valor)/2)/10;
  @endphp
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
  @if($resultado->fuera_rango)
    <div class="{{$action}}" style="position: absolute;left: {{ $boxes->fuera_rango->x - $ajuste_x}}cm;top: {{ $y }}cm">
      @if($resultado->determinacion->multiples_lineas)
        @php
          $valores = explode('<br />', nl2br($analisis->resultados[0]->valor, '\n'))
        @endphp
        @foreach ($valores as $value)
          {{$value}}<br>
          @php
            $y += $y_acu;
          @endphp
        @endforeach
      @else
        {{$resultado->valor . ' ' . $resultado->determinacion->unidad_medida}}
      @endif
    </div>
  @else
    @php
      if($resultado->determinacion->multiples_lineas){
        $x_ajustada = $boxes->titulo_resultado->x + 1;
        $y += $y_acu;
      }else
        $x_ajustada = $boxes->resultado->x - $ajuste_x;
    @endphp
    <div class="{{$action}}" style="position: absolute;left: {{ $x_ajustada }}cm;top: {{ $y }}cm">
      @if($resultado->determinacion->multiples_lineas)
        @php
          $valores = explode('<br />', nl2br($resultado->valor, '\n'))
        @endphp
        @foreach ($valores as $value)
          {{$value}}<br>
          @php
            $y += $y_acu;
          @endphp
        @endforeach
      @else
        {{$resultado->valor . ' ' . $resultado->determinacion->unidad_medida}}
      @endif
    </div>
  @endif
  <div class="{{$action}}" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia_format . ' ' . $resultado->determinacion->unidad_medida}}</div>
  @php
    $y += $y_acu;
    $seccion_actual = $resultado->determinacion->subseccion->seccion->id;
    $subseccion_actual = $resultado->determinacion->subseccion->id;
  @endphp
@endforeach
