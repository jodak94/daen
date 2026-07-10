@extends('layouts.master')

@section('content-header')
    <h1>
        Pacientes con resultados fuera de rango
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.informes.reporte.index') }}">Reportes</a></li>
        <li class="active">Pacientes con resultados fuera de rango</li>
    </ol>
@stop

@push('css-stack')
    {!! Theme::style('vendor/pickadate/css/classic.css') !!}
    {!! Theme::style('vendor/pickadate/css/classic.date.css') !!}
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('admin.informes.reporte.pacientesFueraDeRangoPdf') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::normalSelect('empresa_id', 'Empresa', $errors, $empresas) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::normalInput('fecha_desde', 'Fecha desde', $errors, null, ['class' => 'form-control fecha_filter']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::normalInput('fecha_hasta', 'Fecha hasta', $errors, null, ['class' => 'form-control fecha_filter']) !!}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fa fa-file-pdf-o"></i> Generar PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js-stack')
    {!! Theme::script('vendor/pickadate/js/picker.js') !!}
    {!! Theme::script('vendor/pickadate/js/picker.date.js') !!}
    <script type="text/javascript">
        $('.fecha_filter').pickadate({
            monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            today: 'Hoy',
            clear: 'Limpiar',
            close: 'Cerrar',
            selectMonths: true,
            selectYears: 100,
            format: 'dd/mm/yyyy'
        });
    </script>
@endpush
