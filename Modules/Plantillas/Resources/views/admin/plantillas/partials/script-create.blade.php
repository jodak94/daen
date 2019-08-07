<script>
  $(document).ready(function(){
    $("#buscar-subseccion").autocomplete({
      source: '{{route('admin.analisis.subseccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        var html = trTitulo(ui.item.titulo, ui.item.id);
        $("#analisisBody").append(html)
        $.each(ui.item.determinacion, function(index, det){
          html
              ="<tr class='determinacion-"+ui.item.id+"'>"
              +"  <td>"+det.titulo
              +"    <input type='hidden' name=determinacion["+det.id+"] value='"+det.id+"'>"
              +"  </td>"
              +"  <td>"
              +"    <button subId="+ui.item.id+" type='button' class='btn btn-danger btn-flat delete-det'>"
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
        $(this).val("")
        return false;
      }
    })
    $("#analisisBody").on('click', '.delete-det', function(){
      if($(".determinacion-"+$(this).attr('subId')).size() == 1)
        $(this).closest('tr').prev().remove()
      $(this).closest('tr').remove()
    })
    $("#analisisBody").on('click', '.delete-sub', function(){
      $(".determinacion-"+$(this).attr('subId')).remove()
      $(this).closest('tr').remove()
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
</script>
