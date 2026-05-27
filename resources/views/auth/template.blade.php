<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanger - Autenticación</title>
    
    <link rel="icon" type="image/png" href="{{ asset('storage/media/images/HANG.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.scss', 'resources/css/tailwind.css', 'resources/js/app.js'])
</head>
<body class="bg-body-bg flex flex-col min-h-screen font-sans text-dark">

    <header class="w-full bg-primary border-b border-primary shadow-sm">
        <div class="max-w-[1400px] mx-auto px-4 py-3 flex justify-center items-center">
            <a href="{{ route('home') }}" class="transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('storage/media/images/HANGER.png') }}" alt="Logo Hanger" class="h-[60px] w-auto object-contain" onerror="this.outerHTML='<span class=\'text-white font-black text-2xl tracking-widest\'>HANGER</span>'">
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center w-full">
        @yield('content')
    </main>

</body>
</html>