<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" type="image/x-icon" href="media/images/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <header>
        <nav class="container-fluid sticky-top bg-light px-3 py-2 border-bottom">
            <div class="row">
                <div class="col-4 d-flex justify-content-start gap-2 gap-md-3 align-items-center">
                    <i id="burger-menu" class="bi bi-list fs-2 clicable mb-0" data-bs-toggle="offcanvas"
                        data-bs-target="#menuLateral"></i>
                    <a href="shop.html" class="text-dark text-decoration-none d-flex align-items-center">
                        <i class="bi bi-shop fs-2 clicable mb-0"></i>
                    </a>
                </div>

                <div class="col-4 d-flex justify-content-center">
                    <img src="media/images/logo.jpg" class="img-fluid logo">
                </div>

                <div class="col-4 d-flex justify-content-end gap-2 gap-md-3 align-items-center">
                    <i id="perfil" class="bi bi-person fs-2 clicable mb-0" data-bs-toggle="offcanvas"
                        data-bs-target="#iniciarSesion"></i>
                    <i class="bi bi-bag fs-2 clicable mb-0"></i>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>