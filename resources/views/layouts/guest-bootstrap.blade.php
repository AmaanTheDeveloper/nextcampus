@extends('layouts.bootstrap')

@section('body')
    <!-- Navbar -->
    @include('layouts.partials.guest-navbar')

    <!-- Page Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.guest-footer')
@endsection
