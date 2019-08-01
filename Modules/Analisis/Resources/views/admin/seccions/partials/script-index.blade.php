<script>
  $(document).ready(function(){
     $("#secciones-table").sortable();
     $("#subsecciones-table").sortable();
     $(".ordenar-subseccion").on('click', function(){
       $.ajax({
         url: "{{route('admin.analisis.seccion.subseccion')}}",
         type: 'GET',
         data: {
           'id': $(this).attr('seccion'),
         },
         success: function(data){
           if(!data.error)
            crearTable(data.subsecciones)
           else
            showMessage("Ocurrio un error en el servidor", 'Error', 'error')
         },
         error: function(error){

         }
       })
     })

     $("#establecer-orden-button").on('click', function(){
       let ss = $(".subseccion-orden");
       let data = [];
       $("#spin").show();
       for (var i = 0; i < ss.length; i++) {
         data.push(ss[i].value)
       }
       $.ajax({
         url: "{{route('admin.analisis.subseccion.ordenar')}}",
         type: 'POST',
         data: {
           'subsecciones': data,
           "_token": "{{ csrf_token() }}",
        },
         success: function(data){
           console.log(data)
           showMessage(data.message, 'Success', 'success')
           $("#modal-ordenar-subsecciones").modal('hide')
           $("#spin").hide();
         },
         error: function(error){
           $("#spin").hide();
           console.log(errror)
           showMessage("Ocurrio un error en el servidor", 'Error', 'error')
         }
       })
     })
  })
  function crearTable(subsecciones){
    let s;
    let html = '';
    for (var i = 0; i < subsecciones.length; i++) {
      s = subsecciones[i];
      html += "<tr>"
           +  " <td class='orden-td'>"
           +  "   <i class='fa fa-sort' aria-hidden='true'></i>"
           +  "   <input type='hidden' value='"+s.id+"' class='subseccion-orden'>"
           +  " </td>"
           +  " <td>"
           +      s.titulo
           +  " </td>"
           +  "</tr>"
    }
    $("#subsecciones-table").html(html)
    $("#modal-ordenar-subsecciones").modal('show')
  }

  function showMessage(message, type, icon){
    $.toast({
      heading: type,
      text: message,
      showHideTransition: 'slide',
      icon: icon,
      position: 'top-right'
    })
  }
</script>
