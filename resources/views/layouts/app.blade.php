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
        font-size: 0.9rem;

        overflow-y: auto;
        overscroll-behavior: contain;
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
        <h6 class="text-secondary mb-3">MENU</h6>
        <ul class="nav flex-column nav-link">

            <!-- Dashboard -->
            <li>
                <a href="{{ url('/') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- Transactions -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" href="#transactionsMenu" role="button" aria-expanded="false">
                    <span><i class="bi bi-journal-check me-2"></i> Transactions</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse ps-3" id="transactionsMenu">
                    <a href="{{ url('/bank-reconciliation') }}" class="nav-link {{ request()->is('bank-reconciliation') ? 'active' : '' }}">
                        Bank Reconciliation
                    </a>
                    <a href="{{ url('/journal-voucher') }}" class="nav-link {{ request()->is('journal-voucher') ? 'active' : '' }}">
                        Journal Voucher
                    </a>
                    <a href="{{ url('/payment-voucher') }}" class="nav-link {{ request()->is('payment-voucher') ? 'active' : '' }}">
                        Payment Voucher
                    </a>
                    <a href="{{ url('/receipt-voucher') }}" class="nav-link {{ request()->is('receipt-voucher') ? 'active' : '' }}">
                        Receipt Voucher
                    </a>
                </div>
            </li>

            <!-- Financial Statements -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" href="#fsMenu" role="button" aria-expanded="false">
                    <span><i class="bi bi-file-earmark-bar-graph me-2"></i> Financial Statements</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse ps-3" id="fsMenu">
                    <a href="{{ url('/balance-sheet') }}" class="nav-link {{ request()->is('balance-sheet') ? 'active' : '' }}">
                        Balance Sheet
                    </a>
                    <a href="{{ url('/profit-loss') }}" class="nav-link {{ request()->is('profit-loss') ? 'active' : '' }}">
                        Profit & Loss
                    </a>
                    <a href="{{ url('/chart-of-accounts') }}" class="nav-link {{ request()->is('chart-of-accounts') ? 'active' : '' }}">
                        Chart of Accounts
                    </a>
                </div>
            </li>

            <!-- Reports -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="false">
                    <span><i class="bi bi-clipboard-data me-2"></i> Reports</span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse ps-3" id="reportsMenu">
                    <a href="{{ url('/account-ledger-report') }}" class="nav-link {{ request()->is('account-ledger-report') ? 'active' : '' }}">
                        Account Ledger Report
                    </a>
                    <a href="{{ url('/payment-report') }}" class="nav-link {{ request()->is('payment-report') ? 'active' : '' }}">
                        Payment Report
                    </a>
                    <a href="{{ url('/receipt-report') }}" class="nav-link {{ request()->is('receipt-report') ? 'active' : '' }}">
                        Receipt Report
                    </a>
                    <a href="{{ url('/journal-report') }}" class="nav-link {{ request()->is('journal-report') ? 'active' : '' }}">
                        Journal Report
                    </a>
                    <a href="{{ url('/purchase-invoice-report') }}" class="nav-link {{ request()->is('purchase-invoice-report') ? 'active' : '' }}">
                        Purchase Invoice Report
                    </a>
                    <a href="{{ url('/purchase-return-report') }}" class="nav-link {{ request()->is('purchase-return-report') ? 'active' : '' }}">
                        Purchase Return Report
                    </a>
                    <a href="{{ url('/sales-invoice-report') }}" class="nav-link {{ request()->is('sales-invoice-report') ? 'active' : '' }}">
                        Sales Invoice Report
                    </a>
                    <a href="{{ url('/sales-return-report') }}" class="nav-link {{ request()->is('sales-return-report') ? 'active' : '' }}">
                        Sales Return
                    </a>
                    <a href="{{ url('/stock-report') }}" class="nav-link {{ request()->is('stock-report') ? 'active' : '' }}">
                        Stock Report
                    </a>
                </div>
            </li>

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
