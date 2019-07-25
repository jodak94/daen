{{-- Cabecera --}}
<div id="cedula_paciente" style="position: absolute;left: {{ $boxes->cedula_paciente->x }}cm;top: {{ $boxes->cedula_paciente->y }}cm"><b>Paciente: </b>{{$analisis->paciente->cedula}}</div>
<div id="nombre_paciente" style="position: absolute;left: {{ $boxes->nombre_paciente->x }}cm;top: {{ $boxes->nombre_paciente->y }}cm"><b>Nombre: </b>{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido}}</div>
<div id="edad_paciente" style="position: absolute;left: {{ $boxes->edad_paciente->x }}cm;top: {{ $boxes->edad_paciente->y }}cm"><b>Edad: </b>{{$analisis->paciente->edad . ' años'}}</div>
<div id="sexo_paciente" style="position: absolute;left: {{ $boxes->sexo_paciente->x }}cm;top: {{ $boxes->sexo_paciente->y }}cm"><b>Sexo: </b>{{ucfirst($analisis->paciente->sexo)}}</div>
<div id="fecha" style="position: absolute;left: {{ $boxes->fecha->x }}cm;top: {{ $boxes->fecha->y }}cm"><b>Fecha: </b>{{Carbon\Carbon::parse($analisis->created_at)->format('d/m/Y')}}</div>

{{-- Resultados --}}
@php
  $y = $boxes->titulo_resultado->y
@endphp
@foreach ($analisis->resultados as $resultado)
  <div id="fecha" style="position: absolute;left: {{ $boxes->titulo_resultado->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->titulo}}</div>
  @if($resultado->fuera_rango)
    <div id="fecha" style="position: absolute;left: {{ $boxes->fuera_rango->x }}cm;top: {{ $y }}cm">{{$resultado->valor}}</div>
  @else
    <div id="fecha" style="position: absolute;left: {{ $boxes->resultado->x }}cm;top: {{ $y }}cm">{{$resultado->valor}}</div>
  @endif
  <div id="fecha" style="position: absolute;left: {{ $boxes->rango_referencia->x }}cm;top: {{ $y }}cm">{{$resultado->determinacion->rango_referencia}}</div>
  @php
    $y += 0.6
  @endphp
@endforeach
