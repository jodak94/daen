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
  font-size: 12px;
}
.download{
  font-size: 12px;
}
.margin-top{
  @if($action == 'preview')
    margin-top: 0.4cm;
  @endif
  @if($action == 'download' || $action == 'print')
    margin-top: 0.4cm;
  @endif
}
</style>
@php
  switch ($action) {
    case 'preview':
      $y_acu = 0.6;
      break;
    case 'download':
      $y_acu = 0.4;
      break;
    case 'print':
      $y_acu = 0.4;
      break;
  }
@endphp
<body>
    @if($action == 'download')
        <img src="{{ public_path('img/back-resultado-min.jpg')}}" width="100%" style="margin: auto;"/>
    @endif
    @if($action == 'preview')
      <img src="{{ asset('img/back-resultado-min.jpg')}}"  width="100%"/>
    @endif
    @include('analisis::pdf.partials.analisis-partial')
</body>

</html>
