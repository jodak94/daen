<script>
  var paciente;
  @if(isset($analisis))
    var js_data = '<?php echo json_encode($analisis->paciente->toArray()); ?>';
    paciente = JSON.parse(js_data );
  @endif
  $(document).ready(function(){
    $('.fecha').pickadate({
      monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
      today: 'Hoy',
      clear: 'Limpiar',
      close: 'Cerrar',
      selectMonths: true,
      selectYears: 100,
      format:'dd/mm/yyyy'
    });
    $("#add_paciente_button").on('click', function(){
      $("#error").hide();
      let nombre = $("#nombre").val();
      let apellido = $("#apellido").val();
      let fecha_nacimiento = $("#fecha_nacimiento").val();
      let cedula = $("#cedula").val();
      let empresa_id = $("#empresa_id").val()
      if(nombre == '' || apellido == '' || fecha_nacimiento == '' || cedula == ''){
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
            //$("#error").show();
            //$("#error_message").html(data.message);
            $.toast({
              heading: 'Error',
              text: data.message,
              showHideTransition: 'slide',
              icon:'error',
              position: 'top-right'
            })
          }else{
            let np = data.paciente.nombre + ' ' + data.paciente.apellido
            if(data.paciente.cedula)
              np += '. Ci: ' + data.paciente.cedula
            $("#buscar-paciente").val(np)
            paciente = data.paciente
            $("#addPaciente").modal('hide');
            $("#paciente_id").val(data.paciente.id)
            $("#buscar-seccion").prop("disabled", false)
            $("#buscar-subseccion").prop("disabled", false)
            $("#buscar-determinacion").prop("disabled", false)
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
        $("#buscar-seccion").prop("disabled", false)
        $("#buscar-subseccion").prop("disabled", false)
        $("#buscar-determinacion").prop("disabled", false)
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

    $("#fecha_nacimiento").on('change', function(){
      let age = _calculateAge($(this).val())
      $("#paciente-edad").html(age)
    })

    function _calculateAge(birthday) { // birthday is a date
      birthday = new Date(birthday);
      var ageDifMs = Date.now() - birthday.getTime();
      var ageDate = new Date(ageDifMs); // miliseconds from epoch
      return Math.abs(ageDate.getUTCFullYear() - 1970);
    }
  })
</script>
