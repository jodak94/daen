<script type="text/javascript">
  $( document ).ready(function(){
    $('.fecha_filter').pickadate({
      monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
      today: 'Hoy',
      clear: 'Limpiar',
      close: 'Cerrar',
      selectMonths: true,
      selectYears: 100,
      format:'dd/mm/yyyy'
    });

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
        url: '{!! route('admin.analisis.analisis.index_ajax') !!}',
        type: "GET",
        data: function (d){
            d.paciente = $("#paciente").val();
            d.fecha_desde = $("#fecha_desde").val();
            d.fecha_hasta = $("#fecha_hasta").val();
            d.cont_diario = $("#cont").val();
            d.empresa = $("#empresa").val();
        },
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
      },
      columns:[
        { data: 'id', name: 'id' },
        { data: 'paciente_nombre', name: 'paciente_nombre' },
        { data: 'fecha_format', name: 'fecha_format' },
        { data: 'creado_por', name: 'creado_por' },
        { data: 'cont_diario', name: 'cont_diario' },
        { data: 'empresa', name: 'empresa' },
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
    $("#empresa").keyup(function(){
        table.ajax.reload();
    });
    $(".fecha_filter").change(function(){
        table.ajax.reload();
    });
    $("#cont").keyup(function(){
        table.ajax.reload();
    });
    $('.data-table').on('click','.preview',function() {
         var analisis_id = $(this).attr("id").replace("analisis_","");
         $.confirm({
            title: 'Vista Previa',
            boxWidth: '60%',
            useBootstrap: false,
            closeIcon: true,
            escapeKey: true,
            backgroundDismiss: true,
            draggable: false,
            content: 'url:{{route("admin.analisis.analisis.exportar")}}?action=preview&analisis_id='+analisis_id,
            buttons: {
                descargar: function() {
                    location.href = '{{route("admin.analisis.analisis.exportar")}}?action=download&analisis_id='+analisis_id
                }
            }
        });
     });

     $('.data-table').on('click', '.descargar', function(){
       let id = $(this).attr('analisis')
       location.href = '{{route("admin.analisis.analisis.exportar")}}?action=download&analisis_id=' + id + '&firma=' + 'sin_firma';
       return;
       
       $("#analisis_id").val(id);
       $("#passwordDescargar").val('');
       $("#passwordDescargar").val('');
       $('#descargarModal').modal('show')
     })

     $("#descargarModalSubmit").on('click', function(){
       let firma = $("select[name='firma']").val();
       let pass = $('#passwordDescargar').val();
       let id = $('#analisis_id').val();
       if(pass == 'admdaen' || firma == 'sin_firma')
        location.href = '{{route("admin.analisis.analisis.exportar")}}?action=download&analisis_id=' + id + '&firma=' + firma;
       else
         $.toast({
           heading: 'Error',
           text: 'Contraseña incorrecta',
           showHideTransition: 'slide',
           icon:'error',
           position: 'top-right'
         })
     })
  })

  var create_url = '{{ route('admin.analisis.analisis.create') }}';

  $("#buscar-plantilla").autocomplete({
    appendTo: '#addPlantilla',
    source: '{{route('admin.plantillas.plantilla.search_ajax')}}',
    select: function( event, ui){
      let url = create_url + '?plantilla=' + ui.item.id;
      $("#add_plantilla_url").attr("href", url);
    }
  })

  $("#reset-cont").on('click', function(){
    $.ajax({
      url: "{{route('admin.configuraciones.reset_cont')}}",
      type: 'GET',
      success: function(data){
        $("#contador-diario").html('0');
      },
      error: function(error){
        $.toast({
          heading: 'Error',
          text: 'Ocurrio un error en el servidor',
          showHideTransition: 'slide',
          icon:'error',
          position: 'top-right'
        })
      }
    })
  })

  $("#preconfigurarResultado").on('click', function(){

  })
</script>
