@include('analisis::admin.analises.partials.create-fields-header')
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
        @if(!isset($plantilla))
          <div class="row">
            <div class="col-md-4">
                {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null, ['disabled' => true]) !!}
            </div>
            <div class="col-md-4 col-md-offset-1">
                {!! Form::normalInput('buscar-seccion', 'Agregar Grupo', $errors, null, ['disabled' => true]) !!}
            </div>
          </div>
        @endif
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
                  @if($subseccion_actual != $detalle->subseccion->id)
                    <tr class='tr-titulo'>
                      <td colspan='4' style='text-align:center'>
                        <u>{{$detalle->subseccion->titulo}}</u>
                      </td>
                      <td>
                        <button subId='{{$detalle->subseccion->id}}' type='button' class='btn btn-danger btn-flat delete-sub'>
                          <i class='fa fa-trash'></i>
                        </button>
                      </td>
                    </tr>
                  @endif
                  <tr class='determinacion-{{$detalle->subseccion->id}}'>
                     <td>{{$detalle->titulo}}</td>
                     @if($detalle->trato_especial && $detalle->tipo_trato=='antibiograma')
                           <td>
                             <table class='table table-bordered table-hover'>
                                <tr>
                                  <td></td>
                                  <td><b>Sensible</b></td>
                                  <td><b>Resistente</b></td>
                                </tr>
                                @foreach ($detalle->helper as $value)
                                  @php
                                    $value = trim($value);
                                  @endphp
                                  <tr>
                                    <td>{{$value}}</td>
                                    <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='{{$detalle->id}}' tipo='sensible' det='{{$value}}'></td>
                                    <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='{{$detalle->id}}' tipo='resistente' det='{{$value}}'></td>
                                  </tr>
                                @endforeach
                             </table>
                             <input type='hidden'  id='ant-{{$detalle->id}}' value=':' name=determinacion[{{$detalle->id}}]>
                          </td>
                        @elseif($detalle->trato_especial && $detalle->tipo_trato=='select')
                          @php
                            $options = explode('|', $detalle->texto_h);
                          @endphp
                          <td>
                            <select class='form-control valor @php
                            switch ($detalle->tipo_referencia) {
                              case 'booleano':
                                echo 'determinacion-select';
                                break;
                              case 'reactiva':
                                echo 'determinacion-select';
                                break;
                              case 'rango':
                                echo 'determinacion-rango';
                                break;
                              case 'rango_hasta':
                                echo 'determinacion-rango';
                                break;
                              case 'rango_edad':
                                echo 'determinacion-rango-edad';
                                break;
                              case 'rango_sexo':
                                echo 'determinacion-rango-sexo';
                                break;
                              default:
                               echo 's';
                             }
                            @endphp' name=determinacion[{{$detalle->id}}]">
                              @foreach ($options as $option)
                                <option value='{{$option}}'>{{$option}}</option>
                              @endforeach
                            </select>
                          </td>
                        @else
                       @switch ($detalle->tipo_referencia)
                         @case ("booleano")
                           <td>
                              <select class='form-control determinacion-select valor' name=determinacion[{{$detalle->id}}]>
                                <option value=''></option>
                                <option value='Negativo'>Negativo</option>
                                <option value='Positivo'>Positivo</option>
                              </select>
                            </td>
                           @break
                         @case ('reactiva')
                            <td>
                              <select class='form-control valor' name=determinacion[{{$detalle->id}}]>
                                  <option value=''></option>
                                  <option value='No Reactiva'>No Reactiva</option>
                                  <option value='Reactiva'>Reactiva</option>
                              </select>
                            </td>
                           @break;
                         @case ('rango')
                           <td><input class='form-control determinacion-rango valor' name=determinacion[{{$detalle->id}}]></td>
                           @break
                         @case ('rango_edad')
                           <td><input class='form-control determinacion-rango-edad valor' name=determinacion[{{$detalle->id}}]></td>
                           @break
                         @case ('rango_sexo')
                           <td><input class='form-control determinacion-rango-sexo valor' name=determinacion[{{$detalle->id}}]></td>
                           @break
                         @default
                           <td>
                             @if($detalle->multiples_lineas)
                               <textarea class='form-control valor' rows='5' name=determinacion[{{$detalle->id}}]></textarea>
                             @else
                               <input class='form-control valor' value="{{$detalle->valor}}" name=determinacion[{{$detalle->id}}]>
                             @endif
                           </td>
                       @endswitch
                     @endif
                    <td>
                       {{$detalle->rango_referencia_format}}
                       <input type='hidden' class='rango-referencia' value='{{$detalle->rango_referencia}}'>
                    </td>
                    <td class='center'>
                      @if($detalle->tipo_referencia != 'sin_referencia')
                        <input type='checkbox' class='rango-check flat-blue' id='check-{{$detalle->id}}' name=fuera_rango[{{$detalle->id}}]>
                      @endif
                    </td>
                    <td>
                        <button subId="{{$detalle->subseccion->id}}" type='button' class='btn btn-danger btn-flat delete-det'>
                          <i class='fa fa-trash'></i>
                        </button>
                    </td>
                  </tr>
                  @php
                    $subseccion_actual = $detalle->subseccion->id;
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
                @if($ss_actual_id != $detalle->subseccion->id)
                  <tr class="conf-{{$detalle->subseccion->id}}">
                    <td style="text-align:center">
                     {{$detalle->subseccion->titulo}}
                   </td>
                    <td class="center">
                      <div class="checkbox">
                        <input type="checkbox" class="rango-check flat-blue" @if($detalle->mostrar_subtitulo) checked @endif name="mostrar[{{$detalle->subseccion->id}}]">
                      </div>
                    </td>
                  </tr>
                  @php
                    $ss_actual_id = $detalle->subseccion->id;
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
