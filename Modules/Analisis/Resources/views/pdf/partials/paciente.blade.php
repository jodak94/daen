<div class="{{$action}}" id="cedula_paciente" style="position: absolute;left: {{ $boxes->cedula_paciente->x }}cm;top: {{ $boxes->cedula_paciente->y }}cm"><b>Paciente: </b>{{$analisis->paciente->cedula_format}}</div>
<div class="{{$action}}" id="nombre_paciente" style="position: absolute;left: {{ $boxes->nombre_paciente->x }}cm;top: {{ $boxes->nombre_paciente->y }}cm"><b>Nombre: </b>{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido}}</div>
<div class="{{$action}}" id="edad_paciente" style="position: absolute;left: {{ $boxes->edad_paciente->x }}cm;top: {{ $boxes->edad_paciente->y }}cm"><b>Edad: </b>{{$analisis->paciente->edad . ' años'}}</div>
<div class="{{$action}}" id="sexo_paciente" style="position: absolute;left: {{ $boxes->sexo_paciente->x }}cm;top: {{ $boxes->sexo_paciente->y }}cm"><b>Sexo: </b>{{ucfirst($analisis->paciente->sexo)}}</div>
<div class="{{$action}}" id="fecha" style="position: absolute;left: {{ $boxes->fecha->x }}cm;top: {{ $boxes->fecha->y }}cm"><b>Fecha: </b>{{Carbon\Carbon::parse($analisis->fecha)->format('d/m/Y')}}</div>
<div class="{{$action}}" id="cod" style="position: absolute;left: {{ $boxes->cod->x }}cm;top: {{ $boxes->cod->y }}cm"><b>Cod: </b>{{$analisis->cont_diario}}</div>
