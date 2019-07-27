<script>
  var resultados;
  var actual = -1;
  $(".historial").on('click', function(){
    let paciente_id = $(this).attr('paciente');
    $.ajax({
      type: 'get',
      url: '{{route('admin.pacientes.paciente.get_analisis_id')}}',
      data: {'paciente_id': paciente_id},
      success: function(data) {
        if(!data.error){
          resultados = data.resultados;
          actual = 0;
          mostrar_resultado(resultados[actual]);
        }
       },
     });
  })

  function mostrar_resultado(analisis_id){
    $.confirm({
       title: 'Análisis',
       boxWidth: '60%',
       useBootstrap: false,
       closeIcon: true,
       escapeKey: true,
       backgroundDismiss: true,
       draggable: false,
       content: 'url:{{route("admin.analisis.analisis.exportar")}}?action=preview&analisis_id='+analisis_id,
       buttons: {
          anterior: function() {
             if(actual == 0)
              actual = resultados.length - 1
             else
              actual -= 1;
             mostrar_resultado(resultados[actual])
           },
           siguiente: function() {
              if(actual == resultados.length - 1)
                actual = 0
               else
                actual += 1;
               mostrar_resultado(resultados[actual])
           },
           descargar: function() {
               location.href = '{{route("admin.analisis.analisis.exportar")}}?action=download&analisis_id='+analisis_id
           }
       }
     });
  }
</script>
