<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Análisis</title>
</head>
<style>
@page {
  margin: 0px;
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
.font-13{
  font-size: 13px!important;
}
.font-12{
  font-size: 12px!important;
}
.font-11{
  font-size: 11px!important;
}
.font-10{
  font-size: 10px!important;
}
.font-9{
  font-size: 9px!important;
}
.tituloS{
  text-transform: uppercase;
  text-decoration: underline;
}
.sello{
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px!important;

}
.margin-top{
  @if($action == 'preview')
    margin-top: 0.4cm;
  @endif
  @if($action == 'download' || $action == 'print')
    margin-top: 0.4cm;
  @endif
}
@if($action == 'download')
  img{
    position: absolute;
    top: 0;
    left: 0;
  }
@endif
@if($action == 'preview')
.jconfirm-content-pane{
  padding-left: 0;
  padding-right: 0;
}
@endif
</style>
@php
  switch ($action) {
    case 'preview':
      $y_acu = 0.6;
      break;
    case 'download':
      $y_acu = 0.5;
      break;
    case 'print':
      $y_acu = 0.5;
      break;
  }
@endphp
<body>
    @if($action == 'preview')
      @include('analisis::pdf.partials.analisis-preview-partial')
    @elseif ($action == 'download')
      @include('analisis::pdf.partials.analisis-download-partial')
    @elseif($action == 'print')
      @include('analisis::pdf.partials.analisis-print-partial')
    @endif
</body>

</html>
