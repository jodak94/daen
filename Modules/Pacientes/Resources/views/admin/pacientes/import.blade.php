@extends('layouts.master')

@section('content-header')
    <h1>
        Importar Pacientes
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.pacientes.paciente.index') }}">Pacientes</a></li>
        <li class="active">{{ trans('pacientes::pacientes.title.create paciente') }}</li>
    </ol>
@stop

@push('css-stack')
  {!! Theme::style('vendor/jquery-confirm/jquery-confirm.min.css') !!}
  <style>
    .has-error {
        border-color:#d43f3a;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('themes/adminlte/css/vendor/jQueryUI/jquery-ui-1.10.3.custom.min.css') }}">
@endpush
@section('content')
    {!! Form::open(['route' => ['admin.pacientes.paciente.post_importar'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('pacientes::admin.pacientes.partials.import', ['lang' => $locale])
                        </div>
                    @endforeach
                    <p>En caso de filas con errores, se listaran en esta tabla</p>
                    <table id="table-errors" class="data-table table table-bordered table-hover dataTable no-footer">
                        <thead>
                            <th>
                                <td> Nombre</td>
                                <td> Apellido</td>
                                <td> Cédula</td>
                                <td> Fecha de Nacimiento</td>
                                <td> Sexo</td>
                                <td> Empresa</td>
                            </th>
                        </thead>
                        <tbody>
                            <tr id="sin-datos">
                                <td colspan="6" style="text-align:center"> No se encontraron filas con errores</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="box-footer">
                        <button id ="btn-guardar" type="button" class="btn btn-primary btn-flat" style="display:none" disabled>Guardar Pacientes</button>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}

@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
    {!! Theme::script('vendor/jquery-tabledit/jquery.tabledit.min.js') !!}
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    @include('pacientes::admin.pacientes.partials.script-import')
@endpush
