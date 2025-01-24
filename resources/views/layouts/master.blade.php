<!DOCTYPE html>

<html lang="en">

  @include('templates.header')

  

    <head>

        <!-- <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga4.measurementId') }}"></script>

        <script>

            window.dataLayer = window.dataLayer || [];

            function gtag(){dataLayer.push(arguments);}

            gtag('js', new Date());

            gtag('config', '{{ config('services.ga4.measurementId') }}');

        </script> -->

    </head>



  <body class="h-screen">

    

    <div id="app">@yield('content')</div>

    

    @include('templates.footer')

    <!-- @stack('additional-scripts') -->

  </body>

</html>

