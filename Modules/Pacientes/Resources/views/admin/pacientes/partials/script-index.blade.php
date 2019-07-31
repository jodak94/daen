<script>
  $( document ).ready(function(){
    var table  = $('.data-table').DataTable({
      dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
        "<'row'<'col-xs-12't>>"+
        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
      processing: false,
      serverSide: true,
      "ordering": false,
      "paginate": true,
      "lengthChange": true,
      "iDisplayLength": 50,
      "filter": true,
      "sort": true,
      "info": true,
      "autoWidth": true,
      "paginate": true,
      ajax:{
        url: '{!! route('admin.pacientes.paciente.index_ajax') !!}',
        type: "GET",
        data: function (d){
          d.paciente = $("#paciente").val();
        },
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
      },
      columns:[
        { data: 'nombre', name: 'nombre' },
        { data: 'apellido', name: 'apellido' },
        { data: 'cedula', name: 'cedula' },
        { data: 'acciones', name: 'acciones' },
      ],
      columnDefs: [
        {targets: -1, className: 'center'},
      ],
      language: {
        processing:     "Procesando...",
        search:         "Buscar",
        lengthMenu:     "Mostrar _MENU_ Elementos",
        info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
        infoFiltered:   ".",
        infoPostFix:    "",
        loadingRecords: "Cargando Registros...",
        zeroRecords:    "No existen registros disponibles",
        emptyTable:     "No existen registros disponibles",
        paginate: {
          first:      "Primera",
          previous:   "Anterior",
          next:       "Siguiente",
          last:       "Ultima"
        }
      },
    });
    //filtros
    $("#paciente").keyup(function(){
      table.ajax.reload();
    });
  })
  var resultados;
  var actual = -1;
  $('.data-table').on('click','.historial',function() {
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
       title: 'Historial - ' + (actual+1) + ' de ' + resultados.length,
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
