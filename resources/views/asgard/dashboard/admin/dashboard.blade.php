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
    </div>
  </div>
@stop
