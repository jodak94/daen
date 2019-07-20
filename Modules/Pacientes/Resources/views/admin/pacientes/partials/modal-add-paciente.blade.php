<div class="modal fade" id="addPaciente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cargar Nuevo Paciente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @include('pacientes::admin.pacientes.partials.create-fields')
        <div style="display:none" class="alert alert-danger alert-dismissible" role="alert" id="error">
          <span id="error_message"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_paciente_button" type="button" class="btn btn-primary" style="float:left"><i class="fa fa-spinner fa-spin" aria-hidden="true" style="display:none"></i> Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

@push('js-stack')
  <script>
    $( document ).ready(function() {
      $('#addPaciente').on('hidden.bs.modal', function () {
        $("#nombre").val('')
        $("#apellido").val('')
        $("#fecha_nacimiento").val('')
        $("#cedula").val('')
      })
    });
  </script>
@endpush
