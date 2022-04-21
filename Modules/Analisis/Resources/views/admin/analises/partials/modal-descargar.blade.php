<div class="modal fade modal-descargar" id="descargarModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Descargar resultado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            {!! Form:: normalSelect('firma', "Firma", $errors, ['lujan' => 'Bioq. Ma. Luján Enciso Dacak', 'margarita' => 'Dra. Margarita Dacak', 'sin_firma' => 'Sin Firma']) !!}
          </div>
          <div class="col-md-12">
            {!! Form::normalInputOfType('password', 'passwordDescargar', 'Contraseña', $errors) !!}
          </div>
          <input type="hidden" id="analisis_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat btn-primary" id="descargarModalSubmit" data-dismiss="modal">Aceptar</button>
        <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
