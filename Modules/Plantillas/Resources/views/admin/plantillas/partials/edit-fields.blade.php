<div class="row">
  <div class="col-md-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" style="margin-right: 10px">Plantilla</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            {!! Form::normalInput('nombre', 'Nombre de Plantilla', $errors, $plantilla, ['require' => true]) !!}
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
          <table class="data-table table table-bordered table-hover" id="analisisTable">
            <thead>
              <tr>
                <th>Determinación</th>
                <th>Acción</th>
              </tr>
            </thead>
            @php
              $subseccion_actual = -1;
            @endphp
            <tbody id="analisisBody">
              @foreach ($plantilla->detalles as $detalle)
                @if($subseccion_actual != $detalle->determinacion->subseccion->id)
                  <tr class='tr-titulo'>
                    <td style='text-align:center'>
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
                  <input type='hidden' name=determinacion[{{$detalle->determinacion->id}}] value="{{$detalle->determinacion->id}}">
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
