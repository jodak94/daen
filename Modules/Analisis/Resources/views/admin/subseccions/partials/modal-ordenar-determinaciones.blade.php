<div class="modal fade" id="modal-ordenar-determinaciones" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ordenar Determinaciones</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="data-table-2 table table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%" data-sortable="false">Orden</th>
                <th>Título</th>
            </tr>
            </thead>
            <tbody  id="determinaciones-table">
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button id="establecer-orden-button" type="button" class="btn btn-flat btn-primary" style="float:left"><i class="fa fa-spinner fa-spin" aria-hidden="true" style="display:none"></i> Establecer Orden</button>
        <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
