@extends('layouts.master')

@section('content-header')
    <h1>

    </h1>
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
    </style>
    <style>
    .titulo{font-weight: 500;color:black;}
    .box{
      background: rgba(255,255,255,0.85)!important;
      border-top-color:#2F444E !important;
    }
    .small-box{
      background-color: #00a65a;
    }
    .small-box-footer{
      background-color: #008d4c!important;
    }
    .logo{
        position: absolute;
        right: 20px;
        bottom: 60px;
        width: 25%;
      }
    .adm-wrapper {
      background-image: linear-gradient(315deg, #00a65a, #ecf0f5 30%);
      background-repeat: no-repeat;
      background-position: right bottom;
    }
    .contador-container{
        width: 15%;
        position: absolute;
        left: 25px;
        bottom: 20px;
      }
      .table-bordered-2 > thead > tr > th, .table-bordered-2 > tbody > tr > th, .table-bordered-2 > tfoot > tr > th, .table-bordered-2 > thead > tr > td, .table-bordered-2 > tbody > tr > td, .table-bordered-2 > tfoot > tr > td {
        border: 1px solid #b2b2b2;
      }
      .table-2{
          background-color: #e1e6ed;
      }
      .table-2>tbody>tr>td, .table-2>tbody>tr>th, .table-2>tfoot>tr>td, .table-2>tfoot>tr>th, .table-2>thead>tr>td, .table-2>thead>tr>th {
        padding: 4px;
      }
      .small-box-footer a{
        color: white;
      }
    </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="small-box">
        <a href="{{route('admin.analisis.analisis.index')}}" class="small-box" style="margin-bottom:0px; color:white; padding-bottom: 50px">
          <div class="inner">
            <h4>Resultados</h4>
          </div>
          <div class="icon">
            <i class="fa fa-flask"></i>
          </div>
        </a>
        {{-- <button class="btn btn-primary btn-flat" data-toggle="modal" id="preconfigurarResultado" style="padding: 4px 10px; margin-right: 15px;"> --}}
          {{-- <i class="fa fa-cog"></i> Preconfigurar y Cargar Resultado --}}
        {{-- </button> --}}
        <div class="row small-box-footer" style="margin:0; height: 25px;">
          <div class="col-md-6 col-xs-6" style="padding:0">
            <a href="{{route('admin.analisis.analisis.create')}}">
              Cargar nuevo <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
          <div class="col-md-6 col-xs-6" style="padding:0">
            <a href="javascript:void(0)" id="preconfigurarResultado">
              Preconfigurar nuevo <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box">
        <a href="{{route('admin.empresas.empresa.index')}}" class="small-box" style="margin-bottom:0px; color:white; padding-bottom: 50px">
          <div class="inner">
            <h4>Empresas</h4>
          </div>
          <div class="icon">
            <i class="fa fa-industry"></i>
          </div>
        </a>
        <a href="{{route('admin.empresas.empresa.create')}}" class="small-box-footer" style="height: 25px" >
          Cargar nuevo <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box">
        <a href="{{route('admin.pacientes.paciente.index')}}" class="small-box" style="margin-bottom:0px; color:white; padding-bottom: 50px">
          <div class="inner">
            <h4>Pacientes</h4>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
        </a>
        <a href="{{route('admin.pacientes.paciente.create')}}" class="small-box-footer" style="height: 25px" >
          Cargar nuevo <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="small-box">
        <a href="{{route('admin.plantillas.plantilla.index')}}" class="small-box" style="margin-bottom:0px; color:white; padding-bottom: 50px">
          <div class="inner">
            <h4>Plantillas</h4>
          </div>
          <div class="icon">
            <i class="fa fa-file-text-o"></i>
          </div>
        </a>
        <a href="{{route('admin.plantillas.plantilla.create')}}" class="small-box-footer" style="height: 25px" >
          Cargar nuevo <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>
  <img src="{{url('/img/logo2.png')}}" class="logo">
  @include('analisis::admin.analises.partials.modal-preconfigurarResultado')
@stop
@push('js-stack')
    <script type="text/javascript" src="{{ asset('themes/adminlte/js/vendor/jquery-ui-1.10.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    {!! Theme::script('vendor/pickadate/js/picker.js') !!}
    {!! Theme::script('vendor/pickadate/js/picker.date.js') !!}
    {!! Theme::script('vendor/pickadate/js/picker.time.js') !!}
@endpush
