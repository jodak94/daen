@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('analisis::seccions.title.seccions') }}
    </h1>
    {{-- <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('analisis::seccions.title.seccions') }}</li>
    </ol> --}}
@stop
@push('css-stack')
  <link rel="stylesheet" href="{{ asset('themes/adminlte/css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') }}">
  <style>
    .orden-td{
      text-align: center;
    }
    .orden-td:hover{
      cursor: move;
    }
    .orden-td:active{
      cursor: move;
    }
    .btn{
      height: 34px;
    }
  </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.analisis.seccion.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('analisis::seccions.button.create seccion') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
              {!! Form::open(['route' => ['admin.analisis.seccion.ordenar'], 'method' => 'post']) !!}
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-3">
                      <button type="submit" class="btn btn-primary btn-flat">Establecer Orden</button>
                    </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="5%" data-sortable="false">Orden</th>
                                <th>Título</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody  id="secciones-table">
                            <?php if (isset($seccions)): ?>
                            <?php foreach ($seccions as $seccion): ?>
                            <tr>
                                <td class="orden-td">
                                  <i class="fa fa-sort" aria-hidden="true"></i>
                                  <input type="hidden" value="{{$seccion->id}}" class="seccion-orden" name="seccion[]">
                                </td>
                                <td>
                                    <a href="{{ route('admin.analisis.seccion.edit', [$seccion->id]) }}">
                                        {{ $seccion->titulo }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="ordenar-subseccion btn btn-default btn-flat" seccion="{{$seccion->id}}">Ordenar Subsecciones</button>
                                        <a href="{{ route('admin.analisis.seccion.edit', [$seccion->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.analisis.seccion.destroy', [$seccion->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Orden</th>
                                <th>Título</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
                {!! Form::close() !!}
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
        <dd>{{ trans('analisis::seccions.title.create seccion') }}</dd>
    </dl>
@stop

@include('analisis::admin.seccions.partials.modal-ordenar-subsecciones')
@push('js-stack')
    <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
    @include('analisis::admin.seccions.partials.script-index')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.analisis.seccion.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "pageLength": 100,
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
            // $('.data-table-2').dataTable();
        });
    </script>
@endpush
