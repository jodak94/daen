<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pacientes con resultados fuera de rango</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #222;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            height: 70px;
        }
        .header h2 {
            margin: 8px 0 0;
        }
        .meta {
            width: 100%;
            margin-bottom: 15px;
        }
        .meta td {
            padding: 2px 8px 2px 0;
        }
        table.listado {
            width: 100%;
            border-collapse: collapse;
        }
        table.listado th,
        table.listado td {
            border: 1px solid #999;
            padding: 4px 6px;
            font-size: 11px;
        }
        table.listado th {
            background-color: #eee;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo.jpg') }}">
        <h2>Pacientes con resultados fuera de rango</h2>
    </div>

    <table class="meta">
        <tr>
            <td><b>Fecha de emisión:</b></td>
            <td>{{ \Carbon\Carbon::now()->format('d/m/y') }}</td>
        </tr>
        @if($empresaTitulo)
            <tr>
                <td><b>Empresa:</b></td>
                <td>{{ $empresaTitulo }}</td>
            </tr>
        @endif
        @if($fechaDesde || $fechaHasta)
            <tr>
                <td><b>Período:</b></td>
                <td>{{ $fechaDesde ?: '--' }} al {{ $fechaHasta ?: '--' }}</td>
            </tr>
        @endif
    </table>

    <table class="listado">
        <thead>
            <tr>
                <th>N° Cédula</th>
                <th>Paciente</th>
                <th>Determinación</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resultados as $resultado)
                <tr>
                    <td>{{ $resultado->analisis->paciente->cedula_format }}</td>
                    <td>{{ strtoupper($resultado->analisis->paciente->apellido . ', ' . $resultado->analisis->paciente->nombre) }}</td>
                    <td>{{ $resultado->determinacion->titulo }}</td>
                    <td>{{ $resultado->valor }} {{ $resultado->determinacion->unidad_medida }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center">No se encontraron resultados fuera de rango para los filtros seleccionados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
