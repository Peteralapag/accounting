<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Accounting System')</title>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Styles -->
    @stack('styles')
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
    /* Sidebar */
    #sidebar {
        width: 220px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: #fff;
        border-right: 1px solid #dee2e6;
        padding: 1rem;
        z-index: 1040;

        overflow-y: auto; /* enable vertical scrolling */
        overscroll-behavior: contain;
    }

    /* Content wrapper */
    #contentWrapper {
        margin-left: 220px; /* make space for sidebar */
    }

    /* Navbar container */
    .navbar-container {
        margin-left: 220px; /* same width as sidebar */
    }

    /* Logo spacing */
    .navbar img {
        height: 40px;
        margin-right: 0.5rem;
    }

    /* Sidebar links */
    #sidebar ul.nav-link a {
        display: block;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        color: #0d6efd;
        text-decoration: none;
    }
    #sidebar ul.nav-link a:hover {
        background-color: #e7f1ff;
    }
    #sidebar ul.nav-link a.active {
        background-color: #0d6efd;
        color: #fff !important;
    }
    </style>

</head>
<body class="bg-light">

@auth
    {{-- Top Navbar --}}
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between" style="margin-left:220px;">
            {{-- Company Logo + Dashboard Text --}}
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/jathnier_logo.png') }}" alt="Company Logo">
                <span class="fs-5 fw-bold text-dark">Accounting System</span>
            </div>

            {{-- User & Logout --}}
            <ul class="navbar-nav d-flex flex-row align-items-center mb-0">
                <li class="nav-item me-2">
                    <span class="nav-link mb-0">{{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <a class="btn btn-sm btn-outline-danger" href="{{ route('logout') }}">Logout</a>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Sidebar --}}
    <div id="sidebar">
        <h6 class="text-secondary mb-3">REPORTS</h6>
        <ul class="nav flex-column nav-link">
            <li>
                <a href="{{ url('/') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{ url('/brrr-expense') }}" class="{{ request()->is('brrr-expense') ? 'active' : '' }}">Expenses</a></li>
            <li><a href="{{ url('/brrr-overhead') }}" class="{{ request()->is('brrr-overhead') ? 'active' : '' }}">Overhead</a></li>
            <li><a href="{{ url('/cogs-report') }}" class="{{ request()->is('cogs-report') ? 'active' : '' }}">COGS Report</a></li>
            <li><a href="{{ url('/sales-report') }}" class="{{ request()->is('sales-report') ? 'active' : '' }}">Sales Report</a></li>
            <li><a href="{{ url('/brrr-summary') }}" class="{{ request()->is('brrr-summary') ? 'active' : '' }}">BRRR Summary</a></li>
            <li><a href="{{ url('/brrr-expense') }}" class="{{ request()->is('brrr-expense') ? 'active' : '' }}">Expenses</a></li>
            <li><a href="{{ url('/brrr-overhead') }}" class="{{ request()->is('brrr-overhead') ? 'active' : '' }}">Overhead</a></li>
            <li><a href="{{ url('/cogs-report') }}" class="{{ request()->is('cogs-report') ? 'active' : '' }}">COGS Report</a></li>
            <li><a href="{{ url('/sales-report') }}" class="{{ request()->is('sales-report') ? 'active' : '' }}">Sales Report</a></li>
            <li><a href="{{ url('/brrr-summary') }}" class="{{ request()->is('brrr-summary') ? 'active' : '' }}">BRRR Summary</a></li>
            <li><a href="{{ url('/brrr-expense') }}" class="{{ request()->is('brrr-expense') ? 'active' : '' }}">Expenses</a></li>
            <li><a href="{{ url('/brrr-overhead') }}" class="{{ request()->is('brrr-overhead') ? 'active' : '' }}">Overhead</a></li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div id="contentWrapper">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@endauth

<!-- Scripts -->
@stack('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
