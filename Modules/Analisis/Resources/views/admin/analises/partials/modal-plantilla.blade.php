<div class="modal fade modal-add-paciente" id="addPlantilla" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Seleccionar Plantilla</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::normalInput('buscar-plantilla', 'Buscar Plantilla', $errors, null) !!}
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" id="add_plantilla_url" type="button" class="btn btn-flat btn-primary" style="float:left"> Aceptar</a>
        <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
