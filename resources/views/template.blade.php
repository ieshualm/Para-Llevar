<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de venta comida rapida" />
        <meta name="author" content="Axel Leon & Angel Emmanuel" />
        <title>Para llevar @yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <!--BOOTSTRAP-->
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        @stack('css')
    </head>
    <body class="sb-nav-fixed">
        <x-navigation-header/> <!--Barra de navegación en Compomente-->
        <div id="layoutSidenav">
            <x-navigation-menu/> <!--Menu desplegable contendeor-->
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                <x-footer/> <!-- Componente de Footer-->
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> <!--BOOTSTRAP-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        @stack('js')
    </body>
</html>