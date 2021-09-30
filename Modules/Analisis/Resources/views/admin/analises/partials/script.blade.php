<script>
  $(document).ready(function(){
    $(".number_format_2").number( true , 0, ',', '.' );
    $('.multi-select').select2();
    $("#buscar-subseccion").autocomplete({
      source: '{{route('admin.analisis.subseccion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        agregarSubseccion(ui.item.determinacion, ui.item.titulo, ui.item.id, ui.item.mostrar)
        $(this).val("")
        return false;
      }
    })

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

    $("#buscar-determinacion").autocomplete({
      source: '{{route('admin.analisis.determinacion.search_ajax')}}',
      select: function( event, ui){
        $("#analisisTable").show()
        if(!$('#tr-subid-' + ui.item.subseccion_id).length){
          var html = trTitulo(ui.item.subseccion.titulo, ui.item.subseccion_id);
          var confHtml = trConfiguracion(ui.item.subseccion.titulo, ui.item.subseccion.id, ui.item.subseccion.mostrar)
          $("#configuracionBody").append(confHtml)
          $("#analisisBody").append(html)
        }
        agregarDeterminacion(ui.item, ui.item.subseccion_id, true)
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
      // $(this).closest('tr').remove()
      $(".tr-subid-"+$(this).attr('subId')).remove()
      $(".conf-"+$(this).attr('subId')).remove()
    })

    $(".table").on('keydown', '.valor', function(event){
      if($(this).is("textarea"))
        return;
      if(event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 40){
        event.preventDefault();
        if(!$(this).closest("tr").is(":last-child")){
          let nextTr = $(this).closest('tr').next('tr');
          if(nextTr.hasClass('tr-titulo'))
            nextTr = nextTr.next('tr')
          nextTr.find('.valor').focus()
        }
      }
      if(event.keyCode == 38){
        event.preventDefault();
        if(!$(this).closest("tr").is(":first-child")){
          let prevTr = $(this).closest('tr').prev('tr');
          if(prevTr.hasClass('tr-titulo') && !prevTr.is(":first-child"))
            prevTr = prevTr.prev('tr')
          prevTr.find('.valor').focus()
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
      if($(this).attr('hasta') != undefined){
        if(parseFloat(val) < parseFloat(rango[0]) || parseFloat(val) > parseFloat(rango[1])){
          $('#'+dom.id).iCheck('check');
        }else{
          $('#'+dom.id).iCheck('uncheck');
        }
      }else{
        if(parseFloat(val) < parseFloat(rango[0]) || parseFloat(val) > parseFloat(rango[1])){
          $('#'+dom.id).iCheck('check');
        }else{
          $('#'+dom.id).iCheck('uncheck');
        }
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
      let val = $(this).val().replaceAll(' ', '_').toLowerCase();
      if(val == 'clase_"o"')
        val = 'clase_o';
      let ref = $(this).parent().parent().find('.rango-referencia').val();
      let dom = $(this).parent().parent().find('.rango-check')[0];
      if(val == ''){
        $('#'+dom.id).iCheck('uncheck');
        return;
      }
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

    @if(isset($analisis) || isset($plantilla))
    $(".antCheck").on('ifChanged', function (e) {
    @else
    $(".table").on('ifChanged', '.antCheck', function (e) {
    @endif
      let val = $("#ant-" + $(this).attr('detid')).val();
      let det = $(this).attr('det')
      if($(this)[0].checked){
        let duo;
        if($(this).attr('tipo') == 'sensible'){
          duo = $(this).closest('td').parent().children()[2];
          if($(duo).find('input')[0].checked){
            $(duo).iCheck('uncheck');
            val = borrar(val, det);
          }
          val = det.trim() + ',' + val ;
        }else{
          duo = $(this).closest('td').parent().children()[1];
          if($(duo).find('input')[0].checked){
            $(duo).iCheck('uncheck');
            val = borrar(val, det);
          }
          val += det.trim() + ',';
        }
      }else{
        val = borrar(val, det);
      }
      $("#ant-" + $(this).attr('detid')).val(val);
    })

  })

  function borrar(val, det){
    det = det.trim() + ',';
    val = val.substring(0, val.indexOf(det)) + val.substring(val.indexOf(det) + det.length, val.length);
    return val;
  }

  function agregarSubseccion(determinaciones, subTitulo, subid, mostrarTitulo){
    var html = trTitulo(subTitulo, subid);
    var confHtml = trConfiguracion(subTitulo, subid, mostrarTitulo)
    var idh = null;
    var clh = null;
    $("#configuracionBody").append(confHtml)
    $("#analisisBody").append(html)
    $.each(determinaciones, function(index, det){
      idh = null;
      clh = '';
      if(det.titulo == 'Hematocrito' || det.titulo == 'Glóbulos Rojos')
        clh += 'vcm ';
      if(det.titulo == 'Hematocrito' || det.titulo == 'Hemoglobina')
        clh += 'chcm ';
      if(det.titulo == 'Hemoglobina' || det.titulo == 'Glóbulos Rojos')
        clh += 'hcm ';
      if(det.titulo == 'Hemoglobina' || det.titulo == 'Hematocrito' || det.titulo == 'Glóbulos Rojos' || subTitulo == 'Índices Hematimétricos')
        idh = det.titulo.split(' ').join('_');
      if(subTitulo == 'Índices Hematimétricos')
        idh = det.titulo.split('.').join('').toLowerCase();
      if(subTitulo == 'Formula Leucocitaria Relativa')
        clh = 'checkFormulaLeuco leucoError'
      if(det.titulo == 'Glóbulos Rojos' || det.titulo == 'Glóbulos Blancos')
        clh += 'number_format'
      if(clh == '')
        clh = null;
      agregarDeterminacion(det, subid, false, clh, idh)
      $(".number_format").number( true , 0 );
    })
  }

  function agregarDeterminacion(det, subid, withSub = false, clh = null, idh = null){
    html
        ="<tr class='determinacion-"+subid+"'>"
        +"  <td>"+det.titulo+"</td>"
    if(det.trato_especial && det.tipo_trato=='antibiograma'){
      switch(det.tipo_trato){
        case 'antibiograma':
          html += "<td>"
               +  "  <table class='table table-bordered table-hover'>"
               +  "    <tr>"
               +  "       <td></td>"
               +  "       <td><b>Sensible</b></td>"
               +  "       <td><b>Resistente</b></td>"
               +  "    </tr>";

          det.helper.forEach(el => {
          html += "    <tr>"
               +  "      <td>"+el+"</td>"
               +  "      <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='"+det.id+"' tipo='sensible' det='"+el+"'></td>"
               +  "      <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='"+det.id+"' tipo='resistente' det='"+el+"'></td>";
               +  "    </tr>";
          });
          html += "   </table>"
               +  "  <input type='hidden' name=determinacion["+det.id+"] id='ant-"+det.id+"' value=':'>"
               +  "</td>";
          break;
      }
    }else if(det.trato_especial && det.tipo_trato=='select'){
      let options = det.texto_h.split("|");
      html += "<td>"
           +  " <select class='form-control valor "+ getRefClass(det.tipo_referencia) +"' name=determinacion["+det.id+"]>";
           for(var i = 0; i < options.length; i++){
             html += "<option value='"+options[i]+"'>"+options[i]+"</option>";
           }
      html += " </select>"
           +  "</td>"
    }else if(det.trato_especial && det.tipo_trato=='multi_select'){
     let options = det.texto_h.split("|");
       html += "<td>"
            +  " <select class='form-control valor multi-select "+ getRefClass(det.tipo_referencia) +"' detid='"+det.id+"' multiple='multiple'>";
            for(var i = 0; i < options.length; i++){
              html += "<option value='"+options[i]+"'>"+options[i]+"</option>";
            }
       html += " </select>"
            +  "<input type='hidden' name=determinacion["+det.id+"] id='multi-"+det.id+"'>"
            +  "</td>";

    }else{
      switch (det.tipo_referencia) {
        case 'booleano':
          html += "<td>"
               +  " <select class='form-control determinacion-select valor' name=determinacion["+det.id+"]>"
               +  "   <option value=''></option>"
               +  "   <option value='Negativo'>Negativo</option>"
               +  "   <option value='Positivo'>Positivo</option>"
               +  " </select>"
               +  "</td>"
          break;
        case 'reactiva':
          html += "<td>"
                +  " <select class='form-control determinacion-select  valor' name=determinacion["+det.id+"]>"
                +  "   <option value=''></option>"
                +  "   <option value='No Reactiva'>No Reactiva</option>"
                +  "   <option value='Reactiva'>Reactiva</option>"
                +  " </select>"
                +  "</td>"
          break;
        case 'rango':
          html += "<td><input autocomplete='off' class='form-control determinacion-rango valor "

          if(clh != null)
              html += " " + clh
          html += "'"
          if(idh != null)
            html += " id='" + idh + "'";
          html += " name=determinacion["+det.id+"]></td>"

          break;
        case 'rango_hasta':
          html += "<td><input autocomplete='off' class='form-control determinacion-rango valor' hasta='true' name=determinacion["+det.id+"]></td>"
          break;
        case 'rango_edad':
          html += "<td><input autocomplete='off' class='form-control determinacion-rango-edad valor' name=determinacion["+det.id+"]></td>"
          break;
        case 'rango_sexo':
          html += "<td><input autocomplete='off' class='form-control determinacion-rango-sexo valor "

          if(clh != null)
              html += " " + clh
          html += "'"
          if(idh != null)
            html += " id='" + idh + "'";
          html += " name=determinacion["+det.id+"]></td>"
          break;
        default:
          if(det.multiples_lineas){
            html += "<td><textarea class='form-control valor' name=determinacion["+det.id+"] rows='5'>"
            if(det.texto_por_defecto != null)
              html += det.texto_por_defecto
            html += "</textarea></td>";
          }else{
            html += "<td><input autocomplete='off' class='form-control valor"
            if(clh != null)
              html += " " + clh
            html += "' name=determinacion["+det.id+"] "
            if(idh != null)
              html += "id='"+idh+"'";
            html += '></td>';

          }
      }
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
        +"    <button subId="+subid+" type='button' class='btn btn-danger btn-flat delete-det'>"
        +"      <i class='fa fa-trash'></i>"
        +"    </button>"
        +"  </td>"
        +"</tr>"
    if(!withSub)
      $("#analisisBody").append(html)
    else{
      let bdom;
      if(!$('.determinacion-'+subid).length)
        bdom = $('#tr-subid-' + subid)
      else
        bdom = $('.determinacion-'+subid).last();
      $(html).insertAfter($(bdom))
    }
    $('.multi-select').select2();
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
  }

  function getRefClass(tipo_ref){
    switch (tipo_ref) {
      case 'booleano':
        return 'determinacion-select';
      case 'reactiva':
        return 'determinacion-select';
      case 'no_aglutina_dil_1:20':
        return 'determinacion-select';
      case 'negativo_dil_1:20':
        return 'determinacion-select';
      case 'clase_o':
        return 'determinacion-select';
      case 'rango':
        return 'determinacion-rango';
      case 'rango_hasta':
        return 'determinacion-rango';
      case 'rango_edad':
        return 'determinacion-rango-edad';
      case 'rango_sexo':
        return 'determinacion-rango-sexo';
      default:
      return '';

    }
  }

  function trTitulo(titulo, id){
    var html
        ="<tr class='tr-titulo tr-subid-"+id+"' id='tr-subid-"+id+"'>"
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

  function trConfiguracion(titulo, id, mostrarTitulo){
    var html
        ="<tr class='conf-"+id+"'>"
        +"  <td style='text-align:center'>"
        +     titulo
        +   "</td>"
        +"  <td class='center'>"
        +"    <div class='checkbox'>"
        +"      <input type='checkbox' class='rango-check flat-blue' "+ (mostrarTitulo?"checked ": "") +"name='mostrar["+id+"]'>"
        +"    </div>"
        +"  </td>"
        +"</tr>"
    return html;
  }

  $(".table").on('change', '.multi-select', function(event){
    let val = '';
    let sep = '';
    $.each($(this).select2('data'), function(i, value){
      val += (i?'\n':'') + value.text
    })
    $("#multi-"+$(this).attr('detid')).val(val);
  });

  $(".table").on('keyup', '.vcm', function(event){
    let hema = $('#Hematocrito').val();
    let gr = $('#Glóbulos_Rojos').val();
    if(hema > 0 && gr > 0){
      let val = (hema * 10) / ( Math.floor(gr/1000000 * 10) / 10 )
      $('#vcm').val(val.toFixed(1));
      $('#vcm').keyup();
    }
  })
  $(".table").on('keyup', '.chcm', function(event){
    let hemo = $('#Hemoglobina').val();
    let hema = $('#Hematocrito').val();


    if(hema > 0 && hema > 0){
      let val = (hemo * 100) / hema
      $('#chcm').val(val.toFixed(1));
      $('#chcm').keyup();
    }
  })
  $(".table").on('keyup', '.hcm', function(event){
    let hemo = $('#Hemoglobina').val();
    let gr = $('#Glóbulos_Rojos').val();
    if(hemo > 0 && gr > 0){
      let val = (hemo * 10) / ( Math.floor(gr/1000000 * 10) / 10 )
      $('#hcm').val(val.toFixed(1));
      $('#hcm').keyup();
    }
  })

  function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
  }

  $(".table").on('keyup', '.checkFormulaLeuco', function(event){
    let count = 0;
    $(".checkFormulaLeuco").each(function(  ) {
      if(!isNaN(parseInt($(this).val())) ){
        count += parseInt($(this).val());
      }
    });
    if(count != 100)
      $(".checkFormulaLeuco").addClass('leucoError')
    else
      $(".checkFormulaLeuco").removeClass('leucoError')
  })

  $(".number_format").number( true , 0 );
</script>
