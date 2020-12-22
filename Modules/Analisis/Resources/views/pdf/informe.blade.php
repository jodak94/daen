<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Informe - {{$analisis->paciente->cedula_format}}</title>
  </head>
  <style>
    @page {
      margin: 0px;
    }
    .img-bg{
      position: absolute;
      top: 0;
      left: 0;
    }
    .download{
      font-size: 15px;
    }
    .preview{
      font-size: 18px;
    }
    .print{
      font-size: 15px;
    }
    .download{
      font-size: 15px;
    }
    .texto-ref{
      font-size: 13px!important;
    }
    .tituloS{
      text-transform: uppercase;
      text-decoration: underline;
    }
    .margin-top{
        margin-top: 0.4cm;
    }
    /* img{
      position: absolute;
      top: 0;
      left: 0;
    } */
  </style>
  @php
      $y_acu = 0.5;
  @endphp
  <body>
    <div>
      <div class='row'>
        <div class='col-md-12' style="margin-top: 175px; text-align:center">
          <img src="{{public_path('img/logo.jpg')}}" class="logo">
        </div>
        <div class='col-md-12' style="margin-top: 100px; text-align:center">
          <h2>Informe de estudios medicos y laboratoriales<br>
          ISEPOL - 2021</h2>
        </div>
        <div class='col-md-12' style="margin-top: 150px; margin-left: 60px; font-size: 20px">
          <b>Postulante: </b>{{$analisis->paciente_nombre_print_format}}<br>
          <b>Ci:</b> {{$analisis->paciente->cedula_format}}
        </div>
      </div>
    </div>
    <div style="page-break-after: always;"></div>
    @include('analisis::pdf.partials.analisis-download-partial')
    <div style="page-break-after: always;"></div>
    @php
      $i = 0;
    @endphp
    @foreach ($fotos as $foto)
      @php
        $i++;
      @endphp
      @if($i == 1)
        <img class='img-bg' width="100%" src="{{public_path('img/back-resultado-2.jpg')}}"
        />
        @include('analisis::pdf.partials.paciente')
        <img src='{{public_path($dir . $foto)}}' style='height:200mm; width:auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>
        <div style="page-break-after: always;"></div>
      @else
        <div style='text-align: center; width: 100%'>
          <img src='{{public_path($dir . $foto)}}' style='height:291mm; width:auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>
          @if($i < count($fotos))
            <div style="page-break-after: always;"></div>
          @endif
        </div>
      @endif
    @endforeach
  </body>
</html>
