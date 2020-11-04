<script type="text/javascript">
    $( document ).ready(function() {
        let init_tipo = '{{$determinacion->tipo_referencia}}';
        let init_rango = JSON.parse('{!! json_encode($determinacion->rango) !!}');
        let init_unidad = '{{$determinacion->unidad_medida}}';
        init(init_tipo, init_rango, init_unidad);
        $("[name='tipo_referencia']").on('change', function(){
          let val = $(this).val();
          if(val == init_tipo)
            html = getRangoRefHtml(val, init_rango, init_unidad);
          else
            html = getRangoRefHtml(val);
          $("#rango-container").html(html);
        })
        $('#trato_especial').on('ifChecked', function(event){
            $(".tipo_trato_container").show();
        });

        $('#trato_especial').on('ifUnchecked', function(event){
            $(".tipo_trato_container").hide();
        });
    });
    function init(tipo, rango, unidad_medida){
      html = getRangoRefHtml(tipo, rango, unidad_medida);
      $("#rango-container").html(html);
    }
    function getRangoRefHtml(val, values = undefined, unidad_medida = undefined){
      let html = '';
      if(val != 'sin_referencia' && values == undefined){
        values = new Array();
        values[0] = '';
        values[1] = '';
        values[2] = '';
        values[3] = '';
      }
      if(unidad_medida == undefined)
        unidad_medida = '';
      switch (val) {
        case 'rango':
          html
            ='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Inferior</label>'
            +'     <input placeholder="Rango de referencia" name="rango_referencia_inferior" type="text"  class="form-control" value="'+values[0]+'">'
            +'  </div>'
            +'</div>'
          html
           +='<div class="col-md-2">'
           +'  <div class="form-group ">'
           +'    <label for="rango_referencia">Superior</label>'
           +'    <input placeholder="Rango de referencia" name="rango_referencia_superior" type="text"  class="form-control" value="'+values[1]+'">'
           +'  </div>'
           +'</div>'
            $("#rango-titulo-container").show();
          break;
        case 'rango_sexo':
          html
            ='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Femenino - Inferior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_femenino_inferior" type="text"  class="form-control" value="'+values[0]+'">'
            +'  </div>'
            +'</div>'
          html
            +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Femenino - Superior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_femenino_superior" type="text"  class="form-control" value="'+values[1]+'">'
            +'  </div>'
            +'</div>'
          html
           +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Masculino - Inferior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_masculino_inferior" type="text"  class="form-control" value="'+values[2]+'">'
            +'  </div>'
            +'</div>'
          html
            +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Masculino - Superior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_masculino_superior" type="text"  class="form-control" value="'+values[3]+'">'
            +'  </div>'
            +'</div>'
            $("#rango-titulo-container").show();
            break;
        case 'rango_edad':
          html
            ='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Adultos - Inferior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_adultos_inferior" type="text"  class="form-control" value="'+values[0]+'">'
            +'  </div>'
            +'</div>'
          html
            +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Adultos - Superior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_adultos_superior" type="text"  class="form-control" value="'+values[1]+'">'
            +'  </div>'
            +'</div>'
          html
            +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Niños - Inferior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_ninhos_inferior" type="text"  class="form-control" value="'+values[2]+'">'
            +'  </div>'
            +'</div>'
          html
            +='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Niños - Superior</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia_ninhos_superior" type="text"  class="form-control" value="'+values[3]+'">'
            +'  </div>'
            +'</div>'
            $("#rango-titulo-container").show();
          break;
        case 'booleano':
          html
            ='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Positivo / Negativo</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="Negativo" class="form-control" value="'+values+'" readonly>'
            +'  </div>'
            +'</div>'
            $("#rango-titulo-container").show();
          break;
        case 'reactiva':
          html
            ='<div class="col-md-2">'
            +'  <div class="form-group ">'
            +'    <label for="rango_referencia">Reactiva / No reactiva</label>'
            +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="No Reactiva" class="form-control" value="'+values+'" readonly>'
            +'  </div>'
            +'</div>'
            $("#rango-titulo-container").show();
          break;
          case 'no_aglutina_dil_1:20':
            html
              ='<div class="col-md-2">'
              +'  <div class="form-group ">'
              +'    <label for="rango_referencia">No aglutina dil 1:20</label>'
              +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="No aglutina dil 1:20" class="form-control" readonly>'
              +'  </div>'
              +'</div>'
              $("#rango-titulo-container").show();
            break;
          case 'negativo_dil_1:20':
            html
              ='<div class="col-md-2">'
              +'  <div class="form-group ">'
              +'    <label for="rango_referencia">Negativo dil 1:20</label>'
              +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="Negativo dil 1:20" class="form-control" readonly>'
              +'  </div>'
              +'</div>'
              $("#rango-titulo-container").show();
            break;
          case 'sin_referencia':
            $("#rango-titulo-container").hide();
            break;
        }
        return html;
    }
</script>
