@extends('layouts.master')

@section('content-header')
    <h1>

    </h1>
@stop

@section('styles')
  <style>
  .titulo{font-weight: 500;color:black;}
  .box{
    background: rgba(255,255,255,0.85)!important;
    border-top-color:#2F444E !important;
  }
  .btn{
    min-height: 100px;
  }
  .btn{
    display: table;
  }
  .btn h4{
    vertical-align: middle;
    display: table-cell;
  }
  </style>
@stop

@section('content')
  <div class="box box-primary">
    <div class="box-header">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4 class="titulo"></h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 display-table">
          <a class="btn btn-success btn-lg col-md-12" href="{{route('admin.analisis.analisis.create')}}">
            <h4>Cargar Resultado</h4>
          </a>
        </div>
        <div class="col-md-4 display-table">
          <a class="btn btn-success btn-lg col-md-12" href="{{route('admin.empresas.empresa.index')}}">
            <h4>Empresas</h4>
          </a>
        </div>
        <div class="col-md-4 display-table">
          <a class="btn btn-success btn-lg col-md-12" href="{{route('admin.pacientes.paciente.index')}}">
            <h4>Pacientes</h4>
          </a>
        </div>
      </div>
    </div>
  </div>
@stop
