@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('analisis::seccions.title.create seccion') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.analisis.seccion.index') }}">{{ trans('analisis::seccions.title.seccions') }}</a></li>
        <li class="active">{{ trans('analisis::seccions.title.create seccion') }}</li>
    </ol>
@stop
@push('css-stack')
  <style>
    .background-option{
      border: 12px solid white;
    }
    .background-option:hover{
      cursor: pointer;
    }
    .selected{
      border: 4px solid #ccc;
      border-radius: 5px;
    }
  </style>
@endpush
@section('content')
    {!! Form::open(['route' => ['admin.analisis.seccion.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('analisis::admin.seccions.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.analisis.seccion.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
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
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.analisis.seccion.index') ?>" }
                ]
            });
        });
    </script>
    @include('analisis::admin.seccions.partials.script-create')
@endpush
