<script>
  $(document).ready(function(){
     $("#determinaciones-table").sortable();
     $(".ordenar-determinaciones").on('click', function(){
       $.ajax({
         url: "{{route('admin.analisis.subseccion.determinaciones')}}",
         type: 'GET',
         data: {
           'id': $(this).attr('subseccion'),
         },
         success: function(data){
           if(!data.error)
            crearTable(data.determinaciones)
           else
            showMessage("Ocurrio un error en el servidor", 'Error', 'error')
         },
         error: function(error){

         }
       })
     })

     $("#establecer-orden-button").on('click', function(){
       let ss = $(".determinaciones-orden");
       let data = [];
       $("#spin").show();
       for (var i = 0; i < ss.length; i++) {
         data.push(ss[i].value)
       }
       $.ajax({
         url: "{{route('admin.analisis.determinacion.ordenar')}}",
         type: 'POST',
         data: {
           'determinaciones': data,
           "_token": "{{ csrf_token() }}",
        },
         success: function(data){
           console.log(data)
           showMessage(data.message, 'Success', 'success')
           $("#modal-ordenar-determinaciones").modal('hide')
           $("#spin").hide();
         },
         error: function(error){
           $("#spin").hide();
           console.log(error)
           showMessage("Ocurrio un error en el servidor", 'Error', 'error')
         }
       })
     })
  })
  function crearTable(determinaciones){
    let s;
    let html = '';
    for (var i = 0; i < determinaciones.length; i++) {
      d = determinaciones[i];
      html += "<tr>"
           +  " <td class='orden-td'>"
           +  "   <i class='fa fa-sort' aria-hidden='true'></i>"
           +  "   <input type='hidden' value='"+d.id+"' class='determinaciones-orden'>"
           +  " </td>"
           +  " <td>"
           +      d.titulo
           +  " </td>"
           +  "</tr>"
    }
    $("#determinaciones-table").html(html)
    $("#modal-ordenar-determinaciones").modal('show')
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
