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
  <div class="col-md-3">
    {!! Form::normalInput('fecha', 'Fecha', $errors,(object)['fecha'=>Carbon\Carbon::now()->format('d/m/Y')],['class'=>'form-control fecha']) !!}
  </div>
  <div class="col-md-3">
    {!! Form::normalInput('cont_diario', 'Código', $errors) !!}
  </div>
</div>
