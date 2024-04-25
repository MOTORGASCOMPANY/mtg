<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/mtg.png') }}" />
    <title>MOTORGAS</title>

    <!-- Fonts
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Alexandria:wght@400;600;700&display=swap">
    -->
    
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->

    {{--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/pikaday.css') }}" rel="stylesheet">
    --}}


    @stack('styles')

    @livewireStyles
    @livewireScripts

    <!-- Scripts
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>

         -->


</head>

<body >
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100 flex flex-col -mt-4">
        {{--
        @livewire('navigation-menu')
        --}}

        @livewire('custom-nav-menu')

        <!-- Page Content -->
        <main class="mt-12 mb-1 flex-grow">
            {{ $slot }}
        </main>




    </div>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('modals')
    <!-- 
    <script src="https://kit.fontawesome.com/d1db4754d0.js" crossorigin="anonymous"></script>
    -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @fcScripts
    @stack('js')



    <script>
        livewire.on('alert', function(message) {
            Swal.fire(
                'Buen trabajo!',
                message,
                'success'
            )
        });
    </script>

    <script>
        livewire.on('CustomAlert', function(params) {
            Swal.fire(
                params["titulo"],
                params["mensaje"],
                params["icono"],
            )
        });
    </script>


    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        });
        livewire.on('minAlert', function(params) {
            Toast.fire(
            params["titulo"],
            params["mensaje"],
            params["icono"],
            )
        });
    </script>

    <script>
        Livewire.on('updateChart', data => {
            const chart1=document.getElementById(data["nombre"]);
            chart1.data = data["data"];
            chart1.update();
        });
    </script>
<footer>
    <div class="text-xs text-slate-700  float-right">
        Powered by ECRDEV ®
    </div>
</footer>

</body>

</html>
