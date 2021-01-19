<div class="row" style="margin-bottom: 20px">
  <div class="col-md-4">
    <label for="paciente_id">Paciente</label>
    <div class="input-group ">
      <input placeholder="Ingresar Nombre o Cédula" name="paciente_id" type="text" id="buscar-paciente" class="form-control" value="{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido . '. CI:' . $analisis->paciente->cedula}}">
      <input type="hidden" name="paciente_id" id="paciente_id" value="{{$analisis->paciente->id}}">
      <span class="input-group-btn">
        <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addPaciente" style="height:34px">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
        </button>
      </span>
    </div>
  </div>
  <div class='col-md-2'><span style='color:white'>*</span>
    {!! Form:: normalCheckbox('last_name_first', 'Apellido primero al imprimir', $errors, $analisis) !!}
  </div>
  <div class="col-md-3">
    {!! Form::normalInput('fecha', 'Fecha', $errors,(object)['fecha'=>$analisis->fecha_format],['class'=>'form-control fecha']) !!}
  </div>
  <div class="col-md-3">
    {!! Form::normalInput('cont_diario', 'Código', $errors, $analisis) !!}
  </div>
</div>
<div class="row" id="paciente-box">
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
              <input disabled="disabled" type="text" id="full-name-to-show" class="form-control" value="{{$analisis->paciente->nombre . ' ' . $analisis->paciente->apellido}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Cédula</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="ci-to-show" class="form-control" value="{{$analisis->paciente->cedula_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Sexo</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="sexo-to-show" class="form-control" value="{{$analisis->paciente->sexo_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Fecha de Nacimiento</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="fecha-nacimiento-to-show" class="form-control" value="{{$analisis->paciente->fecha_nacimiento_format}}">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group ">
              <label for="buscar-subseccion">Edad</label>
              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
              <input disabled="disabled" type="text" id="edad-to-show" class="form-control" value="{{$analisis->paciente->edad}}">
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
            {!! Form::normalInput('buscar-seccion', 'Agregar Grupo', $errors, null, ['disabled' => false]) !!}
          </div>
          <div class="col-md-4">
            {!! Form::normalInput('buscar-subseccion', 'Agregar Título', $errors, null, ['disabled' => false]) !!}
          </div>
          <div class="col-md-4">
              {!! Form::normalInput('buscar-determinacion', 'Agregar Determinación', $errors, null, ['disabled' => false]) !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="data-table table table-bordered table-hover" id="analisisTable">
            <thead>
              <tr>
                <th>Determinación</th>
                <th>Valor</th>
                <th>Rango Referencia</th>
                <th>Fuera de rango</th>
                <th>Acción</th>
              </tr>
            </thead>
            @php
              $subseccion_actual = -1;
            @endphp
            <tbody id="analisisBody">
              @foreach ($analisis->resultados as $resultado)
                 @php
                    $clh = '';
                    $idh = null;
                    if($resultado->determinacion->titulo == 'Hematocrito' || $resultado->determinacion->titulo == 'Glóbulos Rojos')
                      $clh .= 'vcm ';
                    if($resultado->determinacion->titulo == 'Hematocrito' || $resultado->determinacion->titulo == 'Hemoglobina')
                      $clh .= 'chcm ';
                    if($resultado->determinacion->titulo == 'Hemoglobina' || $resultado->determinacion->titulo == 'Glóbulos Rojos')
                      $clh .= 'hcm ';

                    if($resultado->determinacion->titulo == 'Hemoglobina' || $resultado->determinacion->titulo == 'Hematocrito' || $resultado->determinacion->titulo == 'Glóbulos Rojos' || $resultado->determinacion->subseccion->titulo == 'Índices Hematimétricos')
                      $idh = (str_replace(' ', '_', $resultado->determinacion->titulo));

                    if($resultado->determinacion->subseccion->titulo == 'Formula Leucocitaria Relativa')
                          $clh = 'checkFormulaLeuco';
                    if($resultado->determinacion->subseccion->titulo == 'Índices Hematimétricos')
                      $idh = strtolower(str_replace('.', '', $resultado->determinacion->titulo));

                    if($resultado->determinacion->titulo == 'Glóbulos Rojos' || $resultado->determinacion->titulo == 'Glóbulos Blancos')
                      $clh .= 'number_format';

                    if($clh == '')
                      $clh = null;

                  @endphp
                @if($subseccion_actual != $resultado->determinacion->subseccion->id)
                  <tr class='tr-titulo tr-subid-{{$resultado->determinacion->subseccion->id}}' id="tr-subid-{{$resultado->determinacion->subseccion->id}}">
                    <td colspan='4' style='text-align:center'>
                      <u>{{$resultado->determinacion->subseccion->titulo}}</u>
                    </td>
                    <td>
                      <button subId='{{$resultado->determinacion->subseccion->id}}' type='button' class='btn btn-danger btn-flat delete-sub'>
                        <i class='fa fa-trash'></i>
                      </button>
                    </td>
                  </tr>
                @endif
                <tr class='determinacion-{{$resultado->determinacion->subseccion->id}}'>
                   <td>{{$resultado->determinacion->titulo}}</td>
                   @if($resultado->determinacion->trato_especial && $resultado->determinacion->tipo_trato=='antibiograma')
                      @php
                        $delimiter = strpos($resultado->valor, ':');
                      @endphp
                       <td>
                         <table class='table table-bordered table-hover'>
                            <tr>
                              <td></td>
                              <td><b>Sensible</b></td>
                              <td><b>Resistente</b></td>
                            </tr>
                            @foreach ($resultado->determinacion->helper as $value)
                              @php
                                $value = trim($value);
                              @endphp
                              <tr>
                                <td>{{$value}}</td>
                                <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='{{$resultado->determinacion->id}}' tipo='sensible' det='{{$value}}' @if(strpos($resultado->valor, $value) !== false && strpos($resultado->valor, $value) < $delimiter) checked @endif></td>
                                <td class='center'><input type='checkbox' class='flat-blue antCheck' detid='{{$resultado->determinacion->id}}' tipo='resistente' det='{{$value}}' @if(strpos($resultado->valor, $value) !== false && strpos($resultado->valor, $value) > $delimiter) checked @endif></td>
                              </tr>
                            @endforeach
                         </table>
                         <input type='hidden'  id='ant-{{$resultado->determinacion->id}}' value='{{$resultado->valor}}' name=determinacion[{{$resultado->determinacion->id}}]>
                      </td>
                   @elseif($resultado->determinacion->trato_especial && $resultado->determinacion->tipo_trato=='select')
                     @php
                       $options = explode('|', $resultado->determinacion->texto_h);
                     @endphp
                     <td>
                       <select class='form-control valor @php
                       switch ($resultado->determinacion->tipo_referencia) {
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
                       @endphp' name=determinacion[{{$resultado->determinacion->id}}]">
                         @foreach ($options as $option)
                           <option @if(trim($resultado->valor) == trim($option)) selected @endif value='{{$option}}'>{{$option}}</option>
                         @endforeach
                       </select>
                     </td>
                   @elseif($resultado->determinacion->trato_especial && $resultado->determinacion->tipo_trato=='multi_select')
                     @php
                       $options = explode('|', $resultado->determinacion->texto_h);
                     @endphp
                     <td>
                       <select class='form-control valor multi-select @php
                       switch ($resultado->determinacion->tipo_referencia) {
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
                       @endphp'  detid='{{$resultado->determinacion->id}}' multiple='multiple'>
                         @foreach ($options as $option)
                           <option @if($option != '' and strpos(trim($resultado->valor), trim($option)) !== false) selected @endif value='{{$option}}'>{{$option}}</option>
                         @endforeach
                       </select>
                       <input type='hidden' value="{{$resultado->valor}}" id='multi-{{$resultado->determinacion->id}}' name=determinacion[{{$resultado->determinacion->id}}]>
                     </td>
                   @else
                     @switch ($resultado->determinacion->tipo_referencia)
                       @case ("booleano")
                         <td>
                            <select class='form-control determinacion-select valor' name=determinacion[{{$resultado->determinacion->id}}]>
                              <option value=''></option>
                              <option @if($resultado->valor == 'Negativo') selected @endif value='Negativo'>Negativo</option>
                              <option @if($resultado->valor == 'Positivo') selected @endif value='Positivo'>Positivo</option>
                            </select>
                          </td>
                         @break
                       @case ('reactiva')
                          <td>
                            <select class='form-control valor' name=determinacion[{{$resultado->determinacion->id}}]>
                                <option value=''></option>
                                <option @if($resultado->valor == 'No Reactiva') selected @endif value='No Reactiva'>No Reactiva</option>
                                <option @if($resultado->valor == 'Reactiva') selected @endif value='Reactiva'>Reactiva</option>
                            </select>
                          </td>
                         @break;
                       @case ('rango')
                         <td><input @if(isset($idh)) id='{{$idh}}' @endif  autocomplete='off' class='form-control determinacion-rango valor @if(isset($clh)) {{$clh}} @endif' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                         @break
                       @case ('rango_edad')
                         <td><input autocomplete='off' class='form-control determinacion-rango-edad valor' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                         @break
                       @case ('rango_sexo')
                         <td><input @if(isset($idh)) id='{{$idh}}' @endif autocomplete='off' class='form-control determinacion-rango-sexo valor @if(isset($clh)) {{$clh}} @endif' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]></td>
                         @break
                       @default
                         <td>
                           @if($resultado->determinacion->multiples_lineas)
                             <textarea class='form-control valor' rows='5' name=determinacion[{{$resultado->determinacion->id}}]>{{trim($resultado->valor)}}</textarea>
                           @else
                             <input @if(isset($idh)) id='{{$idh}}' @endif autocomplete='off' class='form-control valor @if(isset($clh)) {{$clh}} @endif' value="{{$resultado->valor}}" name=determinacion[{{$resultado->determinacion->id}}]>
                           @endif
                         </td>
                    @endswitch
                   @endif
                  <td>
                     {{$resultado->determinacion->rango_referencia_format}}
                     <input type='hidden' class='rango-referencia' value='{{$resultado->determinacion->rango_referencia}}'>
                  </td>
                  <td class='center'>
                    @if($resultado->determinacion->tipo_referencia != 'sin_referencia')
                      <input type='checkbox' class='rango-check flat-blue' id='check-{{$resultado->determinacion->id}}' name=fuera_rango[{{$resultado->determinacion->id}}] @if($resultado->fuera_rango) checked @endif>
                    @endif
                  </td>
                  <td>
                      <button subId="{{$resultado->determinacion->subseccion->id}}" type='button' class='btn btn-danger btn-flat delete-det'>
                        <i class='fa fa-trash'></i>
                      </button>
                  </td>
                </tr>
                @php
                  $subseccion_actual = $resultado->determinacion->subseccion->id;
                @endphp
              @endforeach
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
            @php
              $ss_actual_id = -1;
            @endphp
            @foreach ($analisis->resultados as $resultado)
              @if($ss_actual_id != $resultado->determinacion->subseccion->id)
                <tr class="conf-{{$resultado->determinacion->subseccion->id}}">
                  <td style="text-align:center">
                   {{$resultado->determinacion->subseccion->titulo}}
                 </td>
                  <td class="center">
                    <div class="checkbox">
                      <input type="checkbox" class="rango-check flat-blue" @if($resultado->mostrar_subtitulo) checked @endif name="mostrar[{{$resultado->determinacion->subseccion->id}}]">
                    </div>
                  </td>
                </tr>
                @php
                  $ss_actual_id = $resultado->determinacion->subseccion->id;
                @endphp
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
