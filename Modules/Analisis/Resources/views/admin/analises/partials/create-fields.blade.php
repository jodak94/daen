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
    <div class="pull-right">
      <label>Contador Actual: </label>
      <span id="contador-diario">
        @php
          $cont = DB::select('select * from configuraciones where id = 1')[0]->cont_diario + 1;
          echo($cont);
        @endphp
      </span>
    </div>
  </div>
</div>
<div class="row" id="paciente-box" style="display:none">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Paciente</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Nombre y Apellido</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="full-name-to-show" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Cédula</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="ci-to-show" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Sexo</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="sexo-to-show" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Fecha de Nacimiento</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="fecha-nacimiento-to-show" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Edad</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="edad-to-show" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Análisis</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            @if(isset($plantilla))
              {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null) !!}
            @else
              {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null, ['disabled' => true]) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table @if(!isset($plantilla)) style="display:none" @endif class="data-table table table-bordered table-hover" id="analisisTable">
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
              @if(isset($plantilla))
                @php
                  $subseccion_actual = -1;
                @endphp
                @foreach ($plantilla->detalles as $detalle)
                  @if($subseccion_actual != $detalle->determinacion->subseccion->id)
                    <tr class='tr-titulo'>
                      <td colspan='4' style='text-align:center'>
                        <u>{{$detalle->determinacion->subseccion->titulo}}</u>
                      </td>
                      <td>
                        <button subId='{{$detalle->determinacion->subseccion->id}}' type='button' class='btn btn-danger btn-flat delete-sub'>
                          <i class='fa fa-trash'></i>
                        </button>
                      </td>
                    </tr>
                  @endif
                  <tr class='determinacion-{{$detalle->determinacion->subseccion->id}}'>
                     <td>{{$detalle->determinacion->titulo}}</td>
                     @switch ($detalle->determinacion->tipo_referencia)
                       @case ("booleano")
                         <td>
                            <select class='form-control determinacion-select valor' name=determinacion[{{$detalle->determinacion->id}}]>
                              <option value='Negativo'>Negativo</option>
                              <option value='Positivo'>Positivo</option>
                            </select>
                          </td>
                         @break
                       @case ('reactiva')
                          <td>
                            <select class='form-control valor' name=determinacion[{{$detalle->determinacion->id}}]>
                                <option value='No Reactiva'>No Reactiva</option>
                                <option value='Reactiva'>Reactiva</option>
                            </select>
                          </td>
                         @break;
                       @case ('rango')
                         <td><input class='form-control determinacion-rango valor' value="{{$detalle->valor}}" name=determinacion[{{$detalle->determinacion->id}}]></td>
                         @break
                       @case ('rango_edad')
                         <td><input class='form-control determinacion-rango-edad valor' value="{{$detalle->valor}}" name=determinacion[{{$detalle->determinacion->id}}]></td>
                         @break
                       @case ('rango_sexo')
                         <td><input class='form-control determinacion-rango-sexo valor' value="{{$detalle->valor}}" name=determinacion[{{$detalle->determinacion->id}}]></td>
                         @break
                       @default
                         <td><input class='form-control valor' value="{{$detalle->valor}}" name=determinacion[{{$detalle->determinacion->id}}]></td>
                    @endswitch
                    <td>
                       {{$detalle->determinacion->rango_referencia_format}}
                       <input type='hidden' class='rango-referencia' value='{{$detalle->determinacion->rango_referencia}}'>
                    </td>
                    <td class='center'>
                      @if($detalle->determinacion->tipo_referencia != 'sin_referencia')
                        <input type='checkbox' class='rango-check flat-blue' id='check-{{$detalle->determinacion->id}}' name=fuera_rango[{{$detalle->determinacion->id}}]>
                      @endif
                    </td>
                    <td>
                        <button subId="{{$detalle->determinacion->subseccion->id}}" type='button' class='btn btn-danger btn-flat delete-det'>
                          <i class='fa fa-trash'></i>
                        </button>
                    </td>
                  </tr>
                  @php
                    $subseccion_actual = $detalle->determinacion->subseccion->id;
                  @endphp
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Configuración</h3>
      </div>
      <div class="box-body">
        <table class="data-table table table-bordered table-hover">
          <thead>
            <tr>
              <th>Subtitulo</th>
              <th>Mostrar</th>
            </tr>
          </thead>
          <tbody id="configuracionBody">
            @if(isset($plantilla))
              @php
                $ss_actual_id = -1;
              @endphp
              @foreach ($plantilla->detalles as $detalle)
                @if($ss_actual_id != $detalle->determinacion->subseccion->id)
                  <tr class="conf-{{$detalle->determinacion->subseccion->id}}">
                    <td style="text-align:center">
                     {{$detalle->determinacion->subseccion->titulo}}
                   </td>
                    <td class="center">
                      <div class="checkbox">
                        <input type="checkbox" class="rango-check flat-blue" @if($detalle->mostrar_subtitulo) checked @endif name="mostrar[{{$detalle->determinacion->subseccion->id}}]">
                      </div>
                    </td>
                  </tr>
                  @php
                    $ss_actual_id = $detalle->determinacion->subseccion->id;
                  @endphp
                @endif
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
