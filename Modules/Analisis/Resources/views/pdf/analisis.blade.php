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
    @if($action == 'preview')
      @include('analisis::pdf.partials.analisis-preview-partial')
    @elseif ($action == 'download')
      @include('analisis::pdf.partials.analisis-download-partial')
    @elseif($action == 'print')
      @include('analisis::pdf.partials.analisis-print-partial')
    @endif
</body>

</html>
