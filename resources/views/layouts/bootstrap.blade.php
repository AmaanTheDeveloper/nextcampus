<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NextCampus - Student Opportunity & Career Platform')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Stacked Styles (from layouts/views) -->
    @stack('styles')

    <!-- Custom Styling (Professional Corporate / Academic Theme) -->
   <style>
:root{
    --primary-navy:#0f172a;
    --primary-blue:#1e3a8a;
    --steel-blue:#2563eb;
    --accent-blue:#3b82f6;
    --light-gray:#f8fafc;
    --border-color:#e2e8f0;
    --sidebar-width:260px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--light-gray);
    color:#1e293b;
    overflow-x:hidden;
    min-height:100vh;
}

/* ===========================
    Utilities
=========================== */

.text-navy{
    color:var(--primary-navy)!important;
}

.text-blue-primary{
    color:var(--primary-blue)!important;
}

.text-steel{
    color:var(--steel-blue)!important;
}

/* ===========================
    Cards
=========================== */

.card-premium{
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:14px;
    box-shadow:0 10px 25px rgba(15,23,42,.05);
    transition:.3s;
}

.card-premium:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(37,99,235,.12);
}

/* ===========================
    Buttons
=========================== */

.btn-premium{
    background:var(--primary-blue);
    color:#fff;
    border:none;
    border-radius:10px;
    padding:.7rem 1.2rem;
    transition:.3s;
}

.btn-premium:hover{
    background:var(--steel-blue);
    color:#fff;
}

.btn-premium-outline{
    border:2px solid var(--primary-blue);
    color:var(--primary-blue);
    background:#fff;
    border-radius:10px;
    transition:.3s;
}

.btn-premium-outline:hover{
    background:var(--primary-blue);
    color:#fff;
}

/* ===========================
    Navbar
=========================== */

.navbar-premium{
    background:#fff;
    border-bottom:1px solid var(--border-color);
    position:sticky;
    top:0;
    z-index:1000;
}

.navbar-premium .nav-link{
    color:#475569;
    transition:.3s;
}

.navbar-premium .nav-link:hover{
    color:var(--steel-blue);
}

/* ===========================
    Sidebar
=========================== */

.sidebar{
    background:var(--primary-navy);
    color:#cbd5e1;
    width:var(--sidebar-width);
    min-height:100vh;
    overflow-y:auto;
    scrollbar-width:thin;
}

.sidebar::-webkit-scrollbar{
    width:6px;
}

.sidebar::-webkit-scrollbar-thumb{
    background:#334155;
}

.sidebar .nav-link{
    color:#cbd5e1;
    margin:5px 12px;
    padding:12px 16px;
    border-radius:10px;
    transition:.3s;
    display:flex;
    align-items:center;
    gap:12px;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active{
    background:#1e293b;
    color:#fff;
}

.sidebar .nav-link i{
    font-size:18px;
}

/* ===========================
    Tables
=========================== */

.table{
    vertical-align:middle;
}

.table-responsive{
    border-radius:12px;
}

/* ===========================
    Images
=========================== */

img{
    max-width:100%;
    height:auto;
}

/* ===========================
    Dropdown
=========================== */

.dropdown-menu{
    border:none;
    border-radius:12px;
    box-shadow:0 15px 35px rgba(0,0,0,.12);
}

/* ===========================
    Forms
=========================== */

.form-control,
.form-select{
    border-radius:10px;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--accent-blue);
    box-shadow:0 0 0 .15rem rgba(59,130,246,.2);
}

/* ===========================
    Animations
=========================== */

@keyframes fadeIn{

from{
opacity:0;
transform:translateY(15px);
}

to{
opacity:1;
transform:none;
}

}

.animate-fade-in-up{
animation:fadeIn .5s ease;
}

/* ===========================
    Laptop
=========================== */

@media(min-width:992px){

.container,
.container-lg{
max-width:1320px;
}

}

/* ===========================
    Tablet
=========================== */

@media(max-width:991px){

.sidebar{
width:250px;
}

.card-premium{
padding:20px;
}

}

/* ===========================
    Mobile
=========================== */

@media(max-width:767px){

body{
font-size:14px;
}

h1{
font-size:24px;
}

h2{
font-size:22px;
}

h3{
font-size:20px;
}

.card-premium{
padding:18px;
margin-bottom:15px;
}

.table-responsive{
font-size:13px;
}

.btn{
font-size:14px;
padding:.55rem .9rem;
}

.dropdown-menu{
width:95vw!important;
max-width:95vw;
}

.offcanvas{
width:280px!important;
}

}

/* ===========================
    Small Mobile
=========================== */

@media(max-width:576px){

.container,
.container-fluid{
padding-left:15px!important;
padding-right:15px!important;
}

.btn{
width:auto;
}

.card-premium{
border-radius:12px;
}

}
</style>
</head>
<body>

    <!-- Main Content Area -->
    @yield('body')

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Show SweetAlert Session Alerts -->
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#1e3a8a'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#1e3a8a'
                });
            @endif

            // Initialize general dataTables
            $('.datatables').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records..."
                }
            });
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
