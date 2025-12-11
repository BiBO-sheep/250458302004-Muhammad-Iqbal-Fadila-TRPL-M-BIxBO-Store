<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- owl's stylesheet -->
    <link rel="stylesheet" href="{{ asset('home_asset/css/owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home_asset/css/owl/owl.theme.default.css') }}">

    <!-- main stylesheet -->
    <link rel="stylesheet" href="{{ asset('home_asset/css/style.css') }}">


    <!-- title -->
    <title>BIxBO Store</title>
    @livewireStyles
</head>

<body>
    <!-- header -->
    <header id="header">
        <div class="container">
            <div class="flex justify-content-between align-items-center position-relative">
                <!-- logo -->
                <div>
                    <a class="logo" href="/">
                        <img src="{{ asset('home_asset/img/logo.svg') }}" alt="">
                        <span>BIxBO Store</span>
                    </a>
                </div>

                <!-- search -->
                <div class="search-bar-wrap d-none d-md-block">
                    @livewire('ProductSearchComponent')
                </div>

                <!-- cta buttons -->
                <div class="flex align-items-center gap-3">
                    <a href="#!" class="cart-btn">
                        <i class="fas fa-cart-plus"> </i>
                    </a>

                    <!-- Jika user belum login -->
                    @guest
                        <a href="{{ route('login') }}" class="btn-sm d-none d-sm-inline">
                            Login
                        </a>
                    @endguest

                    <!-- Jika user sudah login -->
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-sm d-none d-sm-inline">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>

                <!-- cart -->
                <div class="cart-wrap">
                    <h6 class="cart-title">Cart</h6>

                    @livewire('CartComponent')
                </div>
            </div>
        </div>
    </header>

    <!-- navbar -->
    <nav class="navbar">
        <div class="container">
            <ul class="navlinks">
                <li>
                    <a href="#!">Trending</a>
                </li>
                <li class="position-relative">
                    <!-- dropdown toggler -->
                    <a class="dropdown-btn" href="#!">
                        <span>Categories</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </a>

                    @php
                        $categories = App\Models\Category::all();
                    @endphp

                    <!-- dropdown links -->
                    <ul class="dropdown-links">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('productby.category', $category->category_name) }}">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li>
                    <a href="#!">Discounts</a>
                </li>
                <li>
                    <a href="#!">Gift Collections</a>
                </li>
                <!-- Item Profile: Hanya muncul jika user sudah login -->
                @if (Auth::check())
                    <li>
                        <a href="{{ route('store') }}">Profile</a>
                        <!-- Ganti route sesuai dengan route profile Anda -->
                    </li>
                @endif
            </ul>

            <!-- mobile search bar -->
            <div class="search-bar-wrap d-block d-md-none">
                <form action="" method="">
                    <div class="search-bar">
                        <input type="text" name="query" placeholder="Search Product..." required>
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
            </div>

            <!-- nav toggler -->
            <div class="nav-toggler d-block d-md-none">
                <a href="#!">
                    <i class="fas fa-bars"></i>
                </a>
            </div>
        </div>
    </nav>


    <!-- main contents -->
    <main>
        @yield('home')

        @livewire('FlashSellCountComponent')

        @livewire('GlobalCartManager')


    </main>

    <!-- footer -->
    @include('layouts.partials.footer')

    @livewireScripts

    <!-- javaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- owl carousel -->
    <script src="{{ asset('home_asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('home_asset/js/owl.carousel.min.js') }}"></script>

    <!-- main js -->
    <script src="{{ asset('home_asset/js/app.js') }}"></script>

    <!-- owl carousel init -->
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoplay: true,
            responsive: {
                0: {
                    items: 1
                }
            }
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tunggu sampai Livewire selesai diinisialisasi
        document.addEventListener('livewire:init', () => {

            // Dengarkan event 'notify' yang dipancarkan dari Livewire
            // Event ini menerima object dengan properti 'title' dan 'type' (dengan nilai default)
            window.livewire.on('notify', ((title = 'Notification', type = 'info') => {
                // Tampilkan di konsol browser (untuk debugging)
                console.log('Livewire Notify received', title, type);

                // Tampilkan notifikasi menggunakan SweetAlert2
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type,
                    title: title,
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            }));
        });
    </script>

    @stack('scripts')
</body>

</html>
