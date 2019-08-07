<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Plantilla</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            {!! Form::normalInput('nombre', 'Nombre de Plantilla', $errors, null, ['required' => true]) !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <table style="display:none" class="data-table table table-bordered table-hover" id="analisisTable">
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
      </div>
    </div>
  </div>
</div>
