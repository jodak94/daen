@if (Session::has('success'))
  <script>
    $(document).on('ready', function(){
      $.toast({
        heading: 'Operación exitosa',
        text: '{{ Session::get('success') }}',
        showHideTransition: 'slide',
        icon:'success',
        position: 'top-right'
      })
    })
  </script>
  @php
    \Session::forget('success', 'Análisis guardado exitosamente')
  @endphp
@endif

@if (Session::has('error'))
  <script>
    $(document).on('ready', function(){
      $.toast({
        heading: 'Error',
        text: '{{ Session::get('error') }}',
        showHideTransition: 'slide',
        icon:'error',
        position: 'top-right'
      })
    })
  </script>
@endif

@if (Session::has('warning'))
  <script>
    $(document).on('ready', function(){
      $.toast({
        heading: 'Atención  ',
        text: '{{ Session::get('warning') }}',
        showHideTransition: 'slide',
        icon:'warning',
        position: 'top-right'
      })
    })
  </script>
@endif


@if (Session::has('errors'))
    <div class="alert alert-danger fade in alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
          @foreach ((array)json_decode(Session::get('errors')) as $campo)
            @foreach ($campo as $error)
              <li>{{$error}}</li>
            @endforeach
          @endforeach
        </ul>
    </div>
    <script>
     @php
     $error = '';
      foreach ((array)json_decode(Session::get('errors')) as $campo){
        foreach ($campo as $error_){
          $error .= ' ' . $error_;
        }
      }
     @endphp
      $(document).on('ready', function(){
        $.toast({
          heading: 'Error',
          text: '{{ $error }}',
          showHideTransition: 'slide',
          icon:'error',
          position: 'top-right'
        })
      })
    </script>
@endif
