<x-layout>
    <main>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000"
            data-bs-pause="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="media/images/banner-example1.jpg" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="media/images/banner-example2.jpg" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="media/images/banner-example3.jpg" class="d-block w-100 h-25 banner-img" alt="..." />
                </div>
            </div>
        </div>
        <div class="row g-4 m-0 px-2 px-md-5 mt-4">
            <div class="col-12">
                <p class="d-block d-md-none display-6 mb-0">Categorías</p>
                <p class="d-none d-md-block display-5 mb-0">Categorías</p>
                <hr class="border-secondary border-3">
            </div>

            @foreach($categories as $category)
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="ratio ratio-1x1 index-video-container clicable">
                        <video muted loop playsinline class="object-fit-cover w-100 h-100 clicable">
                            <source src="{{ $category['video'] }}" type="video/mp4">
                        </video>
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-white">
                            <h1 class="d-none d-sm-block fs-2 fw-bold m-0 p-2 text-center">{{ $category['name'] }}</h1>
                            <h1 class="d-block d-sm-none fs-4 fw-bold m-0 p-2 text-center">{{ $category['name'] }}</h1>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <div class="offcanvas offcanvas-start bg-light text-black" tabindex="-1" id="menuLateral">
        <div class="offcanvas-header">
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled me-4 pe-3">
                <li class="py-2 border-bottom border-secondary"><a href="index.html"
                        class="text-black text-decoration-none fs-5">Inicio</a></li>
                <li class="py-2 border-bottom border-secondary"><a href="#"
                        class="text-black text-decoration-none fs-5">Descubrir - TODO</a></li>
                <li class="py-2 border-bottom border-secondary"><a href="#"
                        class="text-black text-decoration-none fs-5">Social - TODO</a></li>
                <li class="py-2"><a href="#" class="text-black text-decoration-none fs-5">Info - TODO</a></li>
            </ul>
        </div>
    </div>
    <div class="offcanvas offcanvas-end bg-light text-black" tabindex="-1" id="iniciarSesion">
        <div class="offcanvas-header justify-content-end">
            <i class="bi bi-x-lg fs-2 clicable" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
            <form class="me-4 pe-3">
                <label class="form-label" for="username-input">Username:</label>
                <input id="username-input" type="email" class="form-control" placeholder="name@example.com" />
                <label class="form-label mt-3" for="password-input">Password:</label>
                <input id="password-input" type="password" class="form-control" placeholder="*****" />
                <a href="profile.html" type="button" class="btn btn-primary mt-3">Login</a>
            </form>
        </div>
    </div>

    <script src="lib/own/videoHover.js"></script>
    </body>
</x-layout>