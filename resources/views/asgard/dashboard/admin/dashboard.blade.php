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
  .small-box{
    background-color: #00a65a;
  }
  .small-box-footer{
    background-color: #008d4c!important;
  }
  .logo{
      position: absolute;
      right: 20px;
      bottom: 20px;
      width: 25%;
    }
  .content-wrapper {
    background-image: linear-gradient(315deg, #00a65a, #ecf0f5 30%);
    background-repeat: no-repeat;
    background-position: right bottom;
    position: relative;
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
  </style>
@stop

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
        <a href="{{route('admin.analisis.analisis.create')}}" class="small-box-footer" style="height: 25px" >
          Cargar nuevo <i class="fa fa-arrow-circle-right"></i>
        </a>
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
@stop
