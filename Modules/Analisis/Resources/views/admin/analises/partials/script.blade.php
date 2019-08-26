<script>
  $(document).ready(function(){
    var paciente;
    $("#add_paciente_button").on('click', function(){
      $("#error").hide();
      let nombre = $("#nombre").val();
      let apellido = $("#apellido").val();
      let fecha_nacimiento = $("#fecha_nacimiento").val();
      let cedula = $("#cedula").val();
      let empresa_id = $("#empresa_id").val()
      if(nombre == '' || apellido == '' || fecha_nacimiento == '' || cedula == '' ){
        $.toast({
          heading: 'Error',
          text: 'Faltan completar campos',
          showHideTransition: 'slide',
          icon:'error',
          position: 'top-right'
        })
        return;
      }
      $("#spin").show();
      $.ajax({
        url: "{{route('admin.pacientes.paciente.store_ajax')}}",
        type: 'POST',
        data: {
          'nombre': nombre,
          'apellido': apellido,
          'fecha_nacimiento': fecha_nacimiento,
          'cedula': cedula,
          'sexo': $('select[name=sexo]').val(),
          'empresa_id': empresa_id,
          "_token": "{{ csrf_token() }}",
        },
        success: function(data){
          if(data.error){
            $("#error").show();
            $("#error_message").html(data.message);
          }else{
            $("#buscar-paciente").val(
              data.paciente.nombre + ' ' + data.paciente.apellido + '. Ci: ' + data.paciente.cedula
            )
            paciente = data.paciente
            $("#addPaciente").modal('hide');
            $("#paciente_id").val(data.paciente.id)
            $("#buscar-subseccion").prop("disabled", false)
            mostrar_paciente(paciente)
          }
          $("#spin").hide();
        },
        error: function(error){
          $("#spin").hide();
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
    $("#buscar-paciente").autocomplete({
      source: '{{route('admin.pacientes.paciente.search_ajax')}}',
      select: function( event, ui){
        paciente = ui.item.paciente
        $("#paciente_id").val(ui.item.id)
        $("#buscar-subseccion").prop("disabled", false)
        mostrar_paciente(paciente)
      }
    })

    function mostrar_paciente (paciente){
      $("#full-name-to-show").val(paciente.nombre + ' ' + paciente.apellido);
      $("#ci-to-show").val(paciente.cedula_format);
      $("#sexo-to-show").val(paciente.sexo_format);
      $("#fecha-nacimiento-to-show").val(paciente.fecha_nacimiento_format);
      $("#edad-to-show").val(paciente.edad);
      $("#paciente-box").show();
    }

    $("#buscar-empresa").autocomplete({
      appendTo: '.modal-add-paciente',
      source: '{{route('admin.empresas.empresa.search_ajax')}}',
      select: function( event, ui){
        $("#empresa_id").val(ui.item.id)
        $("#box-empresa").show();
        $("#nombre-empresa").html(ui.item.value)
      }
    })

    $("#eliminar-empresa").on('click', function(){
      $("#box-empresa").fadeOut();
      $("#empresa_id").val('');
      $("#buscar-empresa").val('');
    })

    $("#buscar-subseccion").autocomplete({
      source: '{{route('admin.analisis.subseccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        var html = trTitulo(ui.item.titulo, ui.item.id);
        var confHtml = trConfiguracion(ui.item.titulo, ui.item.id)
        $("#configuracionBody").append(confHtml)
        $("#analisisBody").append(html)
        $.each(ui.item.determinacion, function(index, det){
          html
              ="<tr class='determinacion-"+ui.item.id+"'>"
              +"  <td>"+det.titulo+"</td>"
          switch (det.tipo_referencia) {
            case 'booleano':
              html += "<td>"
                   +  " <select class='form-control determinacion-select valor' name=determinacion["+det.id+"]>"
                   +  "   <option value='Negativo'>Negativo</option>"
                   +  "   <option value='Positivo'>Positivo</option>"
                   +  " </select>"
                   +  "</td>"
              break;
            case 'reactiva':
              html += "<td>"
                    +  " <select class='form-control determinacion-select  valor' name=determinacion["+det.id+"]>"
                    +  "   <option value='No Reactiva'>No Reactiva</option>"
                    +  "   <option value='Reactiva'>Reactiva</option>"
                    +  " </select>"
                    +  "</td>"
              break;
            case 'rango':
              html += "<td><input class='form-control determinacion-rango valor' name=determinacion["+det.id+"]></td>"
              break;
            case 'rango_edad':
              html += "<td><input class='form-control determinacion-rango-edad valor' name=determinacion["+det.id+"]></td>"
              break;
            case 'rango_sexo':
              html += "<td><input class='form-control determinacion-rango-sexo valor' name=determinacion["+det.id+"]></td>"
              break;
            default:
              if(det.multiples_lineas)
                html += "<td><textarea class='form-control valor' name=determinacion["+det.id+"] rows='5'></textarea></td>"
              else
                html += "<td><input class='form-control valor' name=determinacion["+det.id+"]></td>"

          }
          html
             +="  <td>"
              +     det.rango_referencia_format
              +"    <input type='hidden' class='rango-referencia' value='"+det.rango_referencia+"'>"
              +"  </td>"
              +"  <td class='center'>";
          if(det.tipo_referencia != 'sin_referencia')
          html
             +="    <input type='checkbox' class='rango-check flat-blue' id='check-"+det.id+"' name=fuera_rango["+det.id+"]>";
          html
             +="  </td>"
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
      $(".conf-"+$(this).attr('subId')).remove()
    })

    $(".table").on('keydown', '.valor', function(event){
      if($(this).is("textarea"))
        return;
      if(event.keyCode == 9 || event.keyCode == 13){
        event.preventDefault();
        if(!$(this).closest("tr").is(":last-child")){
          let nextTr = $(this).closest('tr').next('tr');
          if(nextTr.hasClass('tr-titulo'))
            nextTr = nextTr.next('tr')
          nextTr.find('.valor').focus()
        }
      }
      if(event.keyCode == 13 && $(this).closest("tr").is(":last-child"))
        $("#analisis-form").submit()
    })

    $(".table").on('keyup', '.determinacion-rango', function(event){
      let val = $(this).val()
      let rango = $(this).parent().parent().find('.rango-referencia').val();

      rango = rango.split('-')
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
      if(parseFloat(val) < parseFloat(rango[0]) || parseFloat(val) > parseFloat(rango[1])){
        $('#'+dom.id).iCheck('check');
      }else{
        $('#'+dom.id).iCheck('uncheck');
      }
    })

    $(".table").on('keyup', '.determinacion-rango-edad', function(event){
      let val = $(this).val()
      let rango = $(this).parent().parent().find('.rango-referencia').val();
      rango = rango.replace('|', '-').replace(/[^\d.-]/g,'');
      rango = rango.split('-')
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
      let min = 0;//Niño
      let max = 1;//Niño
      if(paciente.edad > 15){
        min = 2;
        max = 3;
      }
      if(parseFloat(val) < parseFloat(rango[min]) || parseFloat(val) > parseFloat(rango[max])){
        $('#'+dom.id).iCheck('check');
      }else{
        $('#'+dom.id).iCheck('uncheck');
      }
    })

    $(".table").on('keyup', '.determinacion-rango-sexo', function(event){
      let val = $(this).val()
      let rango = $(this).parent().parent().find('.rango-referencia').val();
      rango = rango.replace('|', '-').replace(/[^\d.-]/g,'');
      rango = rango.split('-')
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
      let min = 0;//Fem
      let max = 1;//Fer
      if(paciente.sexo == 'masculino'){
        min = 2;
        max = 3;
      }
      if(parseFloat(val) < parseFloat(rango[min]) || parseFloat(val) > parseFloat(rango[max])){
        $('#'+dom.id).iCheck('check');
      }else{
        $('#'+dom.id).iCheck('uncheck');
      }
    })

    $(".table").on('change', '.determinacion-select', function(event){
      let val = $(this).val().replace(' ', '_').toLowerCase();
      let ref = $(this).parent().parent().find('.rango-referencia').val();
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val != ref)
        $('#'+dom.id).iCheck('check');
      else
        $('#'+dom.id).iCheck('uncheck');
    })

    $("#analisis-form").submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: 'post',
        url: $("#analisis-form").attr("action"),
        data: $("#analisis-form").serialize(),
        success: function(response) {
            if(!response.error){
              window.open('{{route("admin.analisis.analisis.exportar")}}?action=print&analisis_id='+response.analisis_id,"_blank");
              location.href = '{{route('admin.analisis.analisis.index')}}';
            }else
            $.toast({
              heading: 'Error',
              text: response.message,
              showHideTransition: 'slide',
              icon:'error',
              position: 'top-right'
            })
         },
       });
    });

  })

  function trTitulo(titulo, id){
    var html
        ="<tr class='tr-titulo'>"
        +"  <td colspan='4' style='text-align:center'>"
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

  function trConfiguracion(titulo, id){
    var html
        ="<tr class='conf-"+id+"'>"
        +"  <td style='text-align:center'>"
        +     titulo
        +   "</td>"
        +"  <td class='center'>"
        +"    <div class='checkbox'>"
        +"      <input type='checkbox' class='rango-check flat-blue' checked name='mostrar["+id+"]'>"
        +"    </div>"
        +"  </td>"
        +"</tr>"
    return html;
  }
</script>
