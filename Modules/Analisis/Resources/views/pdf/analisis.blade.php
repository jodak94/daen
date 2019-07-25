<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Análisis</title>
</head>
<style>
@page { margin: 0px; }
body { margin: 0px; }
</style>
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
