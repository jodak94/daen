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
<body style="font-size:10px;" >
    @if(isset($preview))
        <img src="{{ public_path('images/factura_Lolo.jpg')}}" style="width:100%;margin-top:8px;"/>
    @endif
    @include('analisis::pdf.partials.analisis-partial')
</body>

</html>
