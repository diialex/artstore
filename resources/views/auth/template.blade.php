<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artesanos - Autenticación</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">E-Commerce Artesanos</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

</body>
</html>