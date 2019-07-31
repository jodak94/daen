@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('analisis::determinacions.title.determinacions') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('analisis::determinacions.title.determinacions') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.analisis.determinacion.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('analisis::determinacions.button.create determinacion') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-3">
                      {!! Form::normalInput('titulo', 'Título', $errors) !!}
                    </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Título</th>
                            <th>Unidad de medida</th>
                            <th>Rango de Referencia</th>
                            <th>Subsección</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <th>Título</th>
                            <th>Unidad de medida</th>
                            <th>Rango de Referencia</th>
                            <th>Subsección</th>
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

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('analisis::determinacions.title.create determinacion') }}</dd>
    </dl>
@stop

@push('js-stack')
    @include('analisis::admin.determinacions.partials.script-index')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.analisis.determinacion.create') ?>" }
                ]
            });
        });
    </script>
@endpush
