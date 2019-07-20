<div class="row" style="margin-bottom: 20px">
  <div class="col-md-4">
    <label for="paciente_id">Paciente</label>
    <div class="input-group ">
      <input placeholder="Ingresar Nombre o Cédula" name="paciente_id" type="text" id="buscar-paciente" class="form-control">
      <input type="hidden" name="paciente_id" id="paciente_id">
      <span class="input-group-btn">
        <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addPaciente" style="height:34px">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Análisis</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null, ['disabled' => true]) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table style="display:none" class="data-table table table-bordered table-hover" id="analisisTable">
            <thead>
              <tr>
                <th>Determinación</th>
                <th>Valor</th>
                <th>Rango Referencia</th>
                <th>Fuera de rango</th>
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
