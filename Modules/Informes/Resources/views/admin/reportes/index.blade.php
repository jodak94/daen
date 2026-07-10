@extends('layouts.master')

@section('content-header')
    <h1>
        Reportes
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">Reportes</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @foreach ($reportes as $reporte)
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $reporte['titulo'] }}</h3>
                    </div>
                    <div class="box-body">
                        <p>{{ $reporte['descripcion'] }}</p>
                        <a href="{{ route($reporte['ruta']) }}" class="btn btn-primary btn-flat">
                            <i class="fa fa-arrow-right"></i> Configurar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
