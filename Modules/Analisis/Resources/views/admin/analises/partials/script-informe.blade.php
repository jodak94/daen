

<script type="text/javascript">
  $( document ).ready(function() {
        $("#img-input").change(function() {
          getBase64(this.files[0]).then(
            data => {
              $("#img-container").append("<div class='col-md-3' sty><img src='"+data+"' width='150' height='150' style='display: flex; margin:auto; margin-top:20px;object-fit:cover'/></div>'")
              $("#inputs-container").append("<input type='hidden' name='fotos[]' value='"+data+"' />")
            }
          );
        });

    });
    function getBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
      });
    }
</script>
