@push('css-stack')
  <style>
    .ui-autocomplete { z-index:2147483647; }
  </style>
@endpush
<div class="modal fade modal-add-paciente" id="preconfigurarResultadoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Preconfigurar Resultado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box-body">
          {!! Form::open(['route' => ['admin.analisis.analisis.preconfigurar-analisis'], 'method' => 'post', 'id' => 'preconfiguracion-form']) !!}
            @include('analisis::admin.analises.partials.create-fields-header')
            <div class="row">
              <div class="col-md-4">
                  {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null, ['disabled' => false]) !!}
              </div>
              <div class="col-md-4 col-md-offset-1">
                  {!! Form::normalInput('buscar-seccion', 'Agregar Grupo', $errors, null, ['disabled' => false]) !!}
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
                <table class="table table-bordered table-hover" id="analisisTable">
                  <thead>
                    <tr>
                      <th>Determinación</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody id="analisisBody">

                  </tbody>
                </table>
              </div>
              <div class="col-md-3">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Subtitulo</th>
                      <th>Mostrar</th>
                    </tr>
                  </thead>
                  <tbody id="configuracionBody">
                  </tbody>
                </table>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" id="validar_configuracion" type="button" class="btn btn-flat btn-primary" style="float:left"> Aceptar</a>
        <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
@push('js-stack')
  @include('analisis::admin.analises.partials.script-paciente')
  @include('plantillas::admin.plantillas.partials.script-create')
  <script>
    $(document).ready(function(){
      $("#preconfigurarResultado").on('click', function(){
        $("#configuracionBody").html('');
        $("#analisisBody").html('');
        $("#paciente_id").val('');
        $("#buscar-paciente").val('');
        $("#cont_diario").val('');
        $('#fecha').val('{{Carbon\Carbon::now()->format('d/m/Y')}}')
        $('#preconfigurarResultadoModal').modal('show')
      })
      $("#validar_configuracion").on('click', function(){
        let error = false;
        if($("#paciente_id").val() == ''){
          mostrar_error('No se encontró el paciente');
          return;
        }
        if($("#cont_diario").val() == ''){
          mostrar_error('No se encontró el código');
          return;
        }
        if($("#analisisBody").children().length == 0){
          mostrar_error('No se encontraron determinaciones');
          return;
        }
        $("#preconfiguracion-form").submit(); 
      })
    })
    function mostrar_error(message){
      $.toast({
        heading: 'Error',
        text: message,
        showHideTransition: 'slide',
        icon:'error',
        position: 'top-right'
      })
    }
  </script>
@endpush
