<!DOCTYPE html>
<html>
<head>
    <base src="{{ URL::asset('/') }}" />
    <meta charset="UTF-8">
    <title>
        @section('title')
            @setting('core::site-name') | Admin
        @show
    </title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-api-token" content="{{ $currentUser->getFirstApiKey() }}">
    <meta name="current-locale" content="{{ locale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    @foreach($cssFiles as $css)
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
    @endforeach
    <link media="all" type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    {!! Theme::script('vendor/jquery/jquery.min.js') !!}
    {!! Theme::style('vendor/jquery-confirm/jquery-confirm.min.css') !!}
    @include('partials.asgard-globals')
    @php
     $x = rand(1,5);
    @endphp
    <style>
      .content-wrapper {
        background-image: url('/img/back{{$x}}.jpg');
        background-size: cover;
        background-repeat: no-repeat;
      }
      .jconfirm .jconfirm-box {
        padding: 0;
      }
      .jconfirm-content-pane{
        padding: 15px;
      }
      .jconfirm-title-c{
        padding: 15px;
        border-bottom: 2px solid rgba(60,141,188, 1);
      }
      .jconfirm-buttons{
        padding: 15px;
      }
    </style>
    {!! Theme::style('vendor/jquery-toast/jquery.toast.min.css') !!}
    @section('styles')
    @show
    @stack('css-stack')
    @stack('translation-stack')

    <script>
        $.ajaxSetup({
            headers: { 'Authorization': 'Bearer {{ $currentUser->getFirstApiKey() }}' }
        });
        var AuthorizationHeaderValue = 'Bearer {{ $currentUser->getFirstApiKey() }}';
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @routes
</head>
<body class="{{ config('asgard.core.core.skin', 'skin-blue') }} sidebar-mini" style="padding-bottom: 0 !important;">
<div class="wrapper" id="app">
    <header class="main-header">
        <a href="{{ route('dashboard.index') }}" class="logo">
            <span class="logo-mini">
                @setting('core::site-name-mini')
            </span>
            <span class="logo-lg">
                @setting('core::site-name')
            </span>
        </a>
        @include('partials.top-nav')
    </header>
    @include('partials.sidebar-nav')

    <aside class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @include('partials.notifications')
            @yield('content')
            <router-view></router-view>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
    @include('partials.footer')
    @include('partials.right-sidebar')
</div><!-- ./wrapper -->

@foreach($jsFiles as $js)
    <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
@endforeach
<script>
    window.AsgardCMS = {
        translations: {!! $staticTranslations !!},
        locales: {!! json_encode(LaravelLocalization::getSupportedLocales()) !!},
        currentLocale: '{{ locale() }}',
        editor: '{{ $activeEditor }}',
        adminPrefix: '{{ config('asgard.core.core.admin-prefix') }}',
        hideDefaultLocaleInURL: '{{ config('laravellocalization.hideDefaultLocaleInURL') }}',
        filesystem: '{{ config('asgard.media.config.filesystem') }}'
    };
</script>

<script src="{{ mix('js/app.js') }}"></script>

<?php if (is_module_enabled('Notification')): ?>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{ Module::asset('notification:js/pusherNotifications.js') }}"></script>
    <script>
        $('.notifications-list').pusherNotifications({
            pusherKey: '{{ config('broadcasting.connections.pusher.key') }}',
            pusherCluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            pusherEncrypted: {{ config('broadcasting.connections.pusher.options.encrypted') }},
            loggedInUserId: {{ $currentUser->id }},
        });
    </script>
<?php endif; ?>

<?php if (config('asgard.core.core.ckeditor-config-file-path') !== ''): ?>
    <script>
        $('.ckeditor').each(function() {
            CKEDITOR.replace($(this).attr('name'), {
                customConfig: '{{ config('asgard.core.core.ckeditor-config-file-path') }}'
            });
        });
    </script>
<?php endif; ?>
{!! Theme::script('vendor/jquery-confirm/jquery-confirm.min.js') !!}
{!! Theme::script('vendor/jquery-toast/jquery.toast.min.js') !!}
@section('scripts')
@show
@stack('js-stack')
</body>
</html>
