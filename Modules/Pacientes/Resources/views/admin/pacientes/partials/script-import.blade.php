<script type="text/javascript">
    $( document ).ready(function() {
        $("#buscar-empresa").autocomplete({
          appendTo: '.modal-add-paciente',
          source: '{{route('admin.empresas.empresa.search_ajax')}}',
          select: function( event, ui){
            $("#empresa_id").val(ui.item.id)
            $("#box-empresa").show();
            $("#nombre-empresa").html(ui.item.value)
          }
        })

        var pacientes;
        var uploaded_files= [];
        $("form").submit(function(e) {
            e.preventDefault();
            var form = $('form');
            var data = new FormData(form[0])

            $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            url: $("form").attr("action"),
            success: function(response) {
                $("#buscar-empresa").attr("disabled", true);
                $("#btn-subir").attr("disabled", true);
                uploaded_files.push(document.querySelector('input[type=file]').files[0].name);
                pacientes= response.pacientes;
                for(let index in response.pacientes) {
                    let paciente = response.pacientes[index];
                    let errores = response.errores[index][0];
                    $("#sin-datos").hide();
                    let row = "<tr id='"+index+"'><td></td>"+
                    "<td> <input type='text'  value='"+(paciente.nombre !== null?paciente.nombre:'')+"' data-key='nombre' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.nombre !== undefined?errores.nombre:'')+"' class='form-control "+(errores.nombre !== undefined?'has-error' : '')+"'></td>"+
                    "<td> <input type='text'  value='"+(paciente.apellido !== null?paciente.apellido:'')+"' data-key='apellido' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.apellido !== undefined?errores.apellido:'')+"' class='form-control "+(errores.apellido !== undefined?'has-error' : '')+"'></td>"+
                    "<td> <input type='number'  value='"+(paciente.cedula!== null?paciente.cedula:'')+"' data-key='cedula' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.cedula !== undefined?errores.cedula:'')+"' class='form-control "+(errores.cedula !== undefined?'has-error' : '')+"'></td>"+
                    "<td> <input type='text'  value='"+(paciente.fecha_nacimiento!== null?paciente.fecha_nacimiento:'')+"' data-key='fecha_nacimiento' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.fecha_nacimiento !== undefined?errores.fecha_nacimiento:'')+"' class='form-control "+(errores.fecha_nacimiento !== undefined?'has-error' : '')+"'></td>"+
                    "<td> <input type='text'  value='"+(paciente.sexo!== null?paciente.sexo:'')+"' data-key='sexo' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.sexo !== undefined?errores.sexo:'')+"' class='form-control "+(errores.sexo !== undefined?'has-error' : '')+"'></td>"+
                    "<td> <input type='number'  value='"+(paciente.empresa!== null?paciente.empresa:'')+"' data-key='empresa' data-toggle='popover' data-placement='top' data-trigger='hover' data-content='"+(errores.empresa !== undefined?errores.empresa:'')+"' class='form-control "+(errores.empresa !== undefined?'has-error' : '')+"'></td>"+
                    "<td style='text-align:center;'><i class='glyphicon glyphicon-trash btn btn-danger remove-field'></td>"+
                    "</tr>";
                    $("#table-errors").find('tbody').append(row);
                    $("#table-errors").trigger("new_row",[index]);
                }
                $("#btn-guardar").show();
                $("[data-toggle=popover]").popover();
                if(response.pacientes.length > 0 && response.cargados > 0) {
                    let htext = '';
                    if(response.pacientes.length > 1){
                      htext = 's';
                    }
                    $.alert({
                    type: 'orange',
                    title: 'Atención',
                    content: 'Se han cargado '+response.cargados+' pacientes nuevos. Pero se encontraron '+response.pacientes.length+' paciente'+htext+' con errores',
                });
                }else if(response.pacientes.length > 0 && response.cargados == 0) {
                    $.alert({
                    type: 'red',
                    title: 'Pacientes con Errores',
                    content: 'No se cargo ningun paciente nuevo. Por favor verifiquelos y vuelva a intentarlo',
                    });
                }else if(response.pacientes.length == 0 && response.cargados > 0) {
                    $.alert({
                    type: 'green',
                    title: 'Pacientes Cargados',
                    content: 'Se han cargado '+response.cargados+' pacientes nuevos.',
                    onClose: function() {
                        location.href = "{{ route('admin.pacientes.paciente.index') }}"
                    }
                    });
                }

            },
            error: function(error) {
              $.alert({
                    type: 'red',
                    title: 'Error',
                    content: 'El archivo debe estar en formato .xls o .xlsx (Excel)',
                    });
            }
          });
        });

        $("#table-errors").on('new_row',function(event,row_id) {
          event.preventDefault();
          $("#"+row_id).find("input").bind('input',function() {
            let index = $(this).parents('tr').attr('id');
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
              }
            });
            let paciente = {
              nombre: $("#"+row_id).find('[data-key=nombre]').val(),
              apellido: $("#"+row_id).find('[data-key=apellido]').val(),
              sexo: $("#"+row_id).find('[data-key=sexo]').val(),
              fecha_nacimiento: $("#"+row_id).find('[data-key=fecha_nacimiento]').val(),
              cedula: $("#"+row_id).find('[data-key=cedula]').val(),
              empresa: $("#"+row_id).find('[data-key=empresa]').val(),
            }
            pacientes[row_id] = paciente;
            $.ajax({
              type: 'POST',
              url: "{{ route('admin.pacientes.paciente.validation')}}",
              contentType: 'application/json',
              dataType: 'json',
              data: JSON.stringify({paciente:paciente}),
              success: function(res) {
                $("#"+row_id).find('.has-error').removeClass('has-error');
                $("#"+row_id).find('.has-error').popover("disable");
              },
              error: function(error) {
                let errorObj = JSON.parse(error.responseText).error;
                $("#"+row_id).find('.has-error').popover("disable");
                $("#"+row_id).find('.has-error').removeClass('has-error');
                for(let key in errorObj){
                  $("#"+row_id).find('[data-key='+key+']').addClass('has-error');
                  $("#"+row_id).find('[data-key='+key+']').attr('data-content',errorObj[key]);
                  $("#"+row_id).find('[data-key='+key+']').popover('enable');
                }
              },
              complete: function() {
                if($('.has-error').length == 0) {
                  $("#btn-guardar").attr("disabled",false);
                }else {
                  $("#btn-guardar").attr("disabled",true);
                }
              }
            })
          })
        })

        $("#table-errors").on('click', '.remove-field', function(){
          delete pacientes[$(this).closest('tr').attr('id')]
          $(this).closest('tr').remove()
        })

        $("#btn-guardar").click(function() {
          if($('.has-error').length == 0) {
            $("#btn-guardar").attr("disabled",false);
            $.ajax({
              type: 'POST',
              url: "{{ route('admin.pacientes.paciente.store_massive_ajax')}}",
              contentType: 'application/json',
              dataType: 'json',
              data: JSON.stringify({pacientes:pacientes, empresa_id: $("#empresa_id").val()}),
              success: function(res) {
                console.log("pacientes Guardados con éxito");
                $.alert({
                  type: 'green',
                  title: 'Pacientes Cargados',
                  content: 'Se han cargado '+res.cargados+' pacientes nuevos.',
                  onClose: function() {
                    location.href = "{{ route('admin.pacientes.paciente.index') }}"
                  }
                });
              },
              error: function(error) {
                console.log(error);
              },
            })
          }else {
            $("#btn-guardar").attr("disabled",true);
          }
        })

        $("#file").change(function(e){
            if(uploaded_files.length > 0) {
                if(uploaded_files.indexOf(e.target.files[0].name) == -1) {
                    $("#btn-subir").attr("disabled",false);
                }else {
                    $("#btn-subir").attr("disabled",true);
                }
            }
        });

        $(".precio").number( true , 0, ',', '.' );
        $(document).keypressAction({
            actions: [
                { key: 'b', route: "<?= route('admin.pacientes.paciente.index') ?>" }
            ]
        });
    });
</script>
