<script>
    $( document ).ready(function() {
        $('#salto_pagina').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        $('#salto_pagina').on('ifChanged', function(event){
          if(event.target.checked){
            $("#background-box").show()
            $("#background").val($($(".background-option")[0]).attr('value'));
          }else{
            $("#background-box").hide()
            $("#background").val('')
          }
        });

        $(".background-option").on('click', function(){
          $(".background-option").removeClass('selected')
          $(this).addClass('selected')
          $("#background").val($(this).attr('value'));
        })
    });
</script>
