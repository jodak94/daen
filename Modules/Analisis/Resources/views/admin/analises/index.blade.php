@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('analisis::analises.title.analises') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('analisis::analises.title.analises') }}</li>
    </ol>
@stop
@push('css-stack')
    <link rel="stylesheet" href="{{ asset('themes/adminlte/css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') }}">
    {!! Theme::style('vendor/pickadate/css/classic.css') !!}
    {!! Theme::style('vendor/pickadate/css/classic.date.css') !!}
    {!! Theme::style('vendor/pickadate/css/classic.time.css') !!}
    <style>
      .picker__select--year{
        padding: 1px;
      }
      .picker__select--month{
        padding: 1px;
      }
      .modal { overflow: auto !important; }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.analisis.analisis.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px; margin-right: 15px;">
                      <i class="fa fa-pencil"></i> {{ trans('analisis::analises.button.create analisis') }}
                    </a>
                    <button class="btn btn-primary btn-flat" data-toggle="modal" id="preconfigurarResultado" style="padding: 4px 10px; margin-right: 15px;">
                      <i class="fa fa-cog"></i> Preconfigurar y Cargar Resultado
                    </button>
                    <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addPlantilla" style="padding: 4px 10px; ">
                      <i class="fa fa-pencil"></i> Cargar desde Plantilla
                    </button>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-3">
                      {!! Form::normalInput('paciente', 'Paciente', $errors) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::normalInput('fecha_desde', 'Fecha desde', $errors,(object)['fecha_desde'=>$from],['class'=>'form-control fecha_filter','id'=>'fecha_desde']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::normalInput('fecha_hasta', 'Fecha hasta', $errors,(object)['fecha_hasta'=>$to],['class'=>'form-control fecha_filter','id'=>'fecha_hasta']) !!}
                    </div>
                    <div class="col-md-3">
                      {!! Form::normalInput('cont', 'Código', $errors) !!}
                    </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                      <table class="data-table table table-bordered table-hover">
                          <thead>
                          <tr>
                              <th>Paciente</th>
                              <th>Fecha</th>
                              <th>Creado Por</th>
                              <th>Código</th>
                              <th>Acciones</th>
                          </tr>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Creado Por</th>
                            <th>Código</th>
                            <th>Acciones</th>
                          </tfoot>
                      </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop
@include('analisis::admin.analises.partials.modal-plantilla')
@include('analisis::admin.analises.partials.modal-preconfigurarResultado')
@include('pacientes::admin.pacientes.partials.modal-add-paciente')
@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('analisis::analises.title.create analisis') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    {!! Theme::script('vendor/pickadate/js/picker.js') !!}
    {!! Theme::script('vendor/pickadate/js/picker.date.js') !!}
    {!! Theme::script('vendor/pickadate/js/picker.time.js') !!}
    @include('analisis::admin.analises.partials.script-index')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.analisis.analisis.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
@endpush
