<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>@yield('title', 'Customer Dashboard')</title>

    <link href="{{ asset('admin_asset/static/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{ route('dashboard') }}">
                    <span class="align-middle">BIxBO Store</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('reviews.my-reviews') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('reviews.my-reviews') }}">
                            <i class="align-middle" data-feather="star"></i> <span class="align-middle">My
                                Reviews</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('customer.history') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('customer.history') }}">
                            <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Order
                                History</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ route('customer.payment') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('customer.payment') }}">
                            <i class="align-middle" data-feather="credit-card"></i> <span
                                class="align-middle">Payment</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('customer.affiliate') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('customer.affiliate') }}">
                            <i class="align-middle" data-feather="users"></i> <span
                                class="align-middle">Affiliate</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <!-- Notifications and Messages dropdowns can be added here if needed -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                                data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=4361ee&color=fff"
                                    class="avatar img-fluid rounded me-1" alt="{{ auth()->user()->name }}" />
                                <span class="text-dark">{{ auth()->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="align-middle me-1" data-feather="user"></i> Profile
                                </a>
                                <a class="dropdown-item" href="/">
                                    <i class="align-middle me-1" data-feather="home"></i> Home
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="align-middle me-1" data-feather="log-out"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Page Header -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="h3 mb-0">@yield('page-title', 'My Reviews')</h1>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/"
                                    target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted"
                                    href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin
                                        Template</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('admin_asset/static/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        <!-- Di bagian bawah sebelum </body>
        -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>

    <script>
        // Initialize all dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>

    <!-- jQuery dulu (jika pakai) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Baru Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
