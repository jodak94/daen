@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('pacientes::pacientes.title.pacientes') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('pacientes::pacientes.title.pacientes') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.pacientes.paciente.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('pacientes::pacientes.button.create paciente') }}
                    </a>
                    <a href="{{ route('admin.pacientes.paciente.get_importar') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px; margin-left: 20px">
                      <i class="fa fa-file-excel-o"></i> Cargar desde Excel
                    </a>
                </div>
            </div>
            <div class="box box-primary">
              <div class="box-header">
                <div class="row">
                  <div class="col-md-3">
                    {!! Form::normalInput('paciente', 'Paciente', $errors) !!}
                  </div>
                  <div class="col-md-3">
                    {!! Form::normalInput('empresa', 'Empresa', $errors) !!}
                  </div>
                </div>
              </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Nombre</th>
                              <th>Apellido</th>
                              <th>Cédula</th>
                              <th>Empresa</th>
                              <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                              <th>Nombre</th>
                              <th>Apellido</th>
                              <th>Cédula</th>
                              <th>Empresa</th>
                              <th>Acciones</th>
                            </tr>
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

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('pacientes::pacientes.title.create paciente') }}</dd>
    </dl>
@stop

@push('js-stack')
    @include('pacientes::admin.pacientes.partials.script-index')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.pacientes.paciente.create') ?>" }
                ]
            });
        });
    </script>
@endpush
