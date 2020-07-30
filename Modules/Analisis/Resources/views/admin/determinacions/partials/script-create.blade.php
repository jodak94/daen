<script type="text/javascript">
    $( document ).ready(function() {
        $("[name='tipo_referencia']").on('change', function(){
          let val = $(this).val();
          let html = '';
          switch (val) {
            case 'rango':
              html
                ='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Inferior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_inferior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
               +='<div class="col-md-2">'
               +'  <div class="form-group ">'
               +'    <label for="rango_referencia">Superior</label>'
               +'    <input placeholder="Rango de referencia" name="rango_referencia_superior" type="text"  class="form-control">'
               +'  </div>'
               +'</div>'
              html
               +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="unidad_medida">Unidad de Medida</label>'
                +'    <input placeholder="Unidad de Medida" name="unidad_medida" type="text" id="unidad_medida" class="form-control">'
                +'  </div>'
                +'</div>'
                $("#rango-titulo-container").show();
              break;
            case 'rango_sexo':
              html
                ='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Femenino - Inferior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_femenino_inferior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Femenino - Superior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_femenino_superior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
               +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Masculino - Inferior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_masculino_inferior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Masculino - Superior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_masculino_superior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="unidad_medida">Unidad de Medida</label>'
                +'    <input placeholder="Unidad de Medida" name="unidad_medida" type="text" id="unidad_medida" class="form-control">'
                +'  </div>'
                +'</div>'
                $("#rango-titulo-container").show();
                break;
            case 'rango_edad':
              html
                ='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Adultos - Inferior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_adultos_inferior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Adultos - Superior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_adultos_superior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Niños - Inferior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_ninhos_inferior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Niños - Superior</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia_ninhos_superior" type="text"  class="form-control">'
                +'  </div>'
                +'</div>'
              html
                +='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="unidad_medida">Unidad de Medida</label>'
                +'    <input placeholder="Unidad de Medida" name="unidad_medida" type="text" id="unidad_medida" class="form-control">'
                +'  </div>'
                +'</div>'
                $("#rango-titulo-container").show();
              break;
            case 'booleano':
              html
                ='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Positivo / Negativo</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="Negativo" class="form-control" readonly>'
                +'  </div>'
                +'</div>'
                $("#rango-titulo-container").show();
              break;
            case 'reactiva':
              html
                ='<div class="col-md-2">'
                +'  <div class="form-group ">'
                +'    <label for="rango_referencia">Reactiva / No reactiva</label>'
                +'    <input placeholder="Rango de referencia" name="rango_referencia" type="text" value="No Reactiva" class="form-control" readonly>'
                +'  </div>'
                +'</div>'
                $("#rango-titulo-container").show();
              break;
            case 'sin_referencia':
              $("#rango-titulo-container").hide();
              break;
          }
          $("#rango-container").html(html);
        })

        $('#trato_especial').on('ifChecked', function(event){
            $(".tipo_trato_container").show();
        });

        $('#trato_especial').on('ifUnchecked', function(event){
            $(".tipo_trato_container").hide();
        });
    });
</script>
