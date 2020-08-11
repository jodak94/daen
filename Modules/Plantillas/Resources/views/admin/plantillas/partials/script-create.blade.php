<script>
  $(document).ready(function(){
    $("#buscar-seccion").autocomplete({
      source: '{{route('admin.analisis.seccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        ui.item.subsecciones.forEach(sub => {
          agregarSubseccion(sub.determinacion, sub.titulo, sub.id, sub.mostrar)
        })
        $(this).val("")
        return false;
      }
    })
    $("#buscar-subseccion").autocomplete({
      source: '{{route('admin.analisis.subseccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        agregarSubseccion(ui.item.determinacion, ui.item.titulo, ui.item.id, ui.item.mostrar)
        $(this).val("")
        return false;
      }
    })
    $("#analisisBody").on('click', '.delete-det', function(){
      if($(".determinacion-"+$(this).attr('subId')).size() == 1){
        $(this).closest('tr').prev().remove()
        $(".conf-"+$(this).attr('subId')).remove()
      }
      $(this).closest('tr').remove()
    })
    $("#analisisBody").on('click', '.delete-sub', function(){
      $(".determinacion-"+$(this).attr('subId')).remove()
      $(this).closest('tr').remove()
      $(".conf-"+$(this).attr('subId')).remove()
    })
  })
  function trTitulo(titulo, id){
    var html
        ="<tr class='tr-titulo'>"
        +"  <td style='text-align:center'>"
        +     "<u>"+titulo+"</u>"
        +   "</td>"
        +"  <td>"
        +"    <button subId='"+id+"' type='button' class='btn btn-danger btn-flat delete-sub'>"
        +"      <i class='fa fa-trash'></i>"
        +"    </button>"
        +"  </td>"
        +"</tr>"
    return html;
  }

  function trConfiguracion(titulo, id, mostrarTitulo){
    var html
        ="<tr class='conf-"+id+"'>"
        +"  <td style='text-align:center'>"
        +     titulo
        +   "</td>"
        +"  <td class='center'>"
        +"    <div class='checkbox'>"
        +"      <input type='checkbox' class='rango-check flat-blue' "+ (mostrarTitulo?"checked ": "") +" checked name='mostrar["+id+"]'>"
        +"    </div>"
        +"  </td>"
        +"</tr>"
    return html;
  }

  function agregarSubseccion(determinaciones, subTitulo, subid, mostrarTitulo){
    var html = trTitulo(subTitulo, subid);
    var confHtml = trConfiguracion(subTitulo, subid, mostrarTitulo)
    $("#configuracionBody").append(confHtml)
    $("#analisisBody").append(html)
    $.each(determinaciones, function(index, det){
      html
          ="<tr class='determinacion-"+subid+"'>"
          +"  <td>"+det.titulo
          +"    <input type='hidden' name=determinacion["+det.id+"] value='"+det.id+"'>"
          +"  </td>"
          +"  <td>"
          +"    <button subId="+subid+" type='button' class='btn btn-danger btn-flat delete-det'>"
          +"      <i class='fa fa-trash'></i>"
          +"    </button>"
          +"  </td>"
          +"</tr>"
      $("#analisisBody").append(html)

      $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
      });
    })
  }
</script>
