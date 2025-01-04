<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .navbar-custom {
            background-color: #007bff;
            color: white;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #d1d1d1;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 8px;
            display: block;
            border-radius: 5px;
            margin: 5px 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #007bff;
        }

        .sidebar .sidebar-header {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            padding: 15px 0;
            background-color: #212529;
        }

        .content-wrapper {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content-wrapper.collapsed {
            margin-left: 0;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            Admin Panel
        </div>
        <a href="{{ route('dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('rooms.index') }}"><i class="fas fa-door-open"></i> Rooms</a>
        <a href="{{ route('room_types.index') }}"><i class="fas fa-layer-group"></i> Room Types</a>
        <a href="{{ route('floors.index') }}"><i class="fas fa-building"></i> Floors</a>
        <a href="{{ route('customers.index') }}"><i class="fas fa-users"></i> Customers</a>
        <a href="{{ route('reservations.index') }}"><i class="fas fa-calendar-check"></i> Reservations</a>
        <a href="{{ route('bookings.index') }}"><i class="fas fa-book"></i> Bookings</a>
        <a href="#"><i class="fas fa-book"></i> Check In</a>
        <a href="#"><i class="fas fa-book"></i> Check Out</a>
        <a href="#"><i class="fas fa-book"></i> Addtional Charges </a>
        <a href="#"><i class="fas fa-book"></i> Reports</a>
        <a href="{{ route('taxes.index') }}"><i class="fas fa-book"></i> Tax Master</a>
        <a href="#"><i class="fas fa-book"></i> Settings</a>

    </div>

    <!-- Main Content -->
    <div class="content-wrapper" id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-custom sticky-top">
            <div class="container-fluid">
                <button class="btn btn-primary d-md-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">Admin Dashboard</a>
                <div class="d-flex align-items-center">
                    <span class="me-3">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Admin Dashboard. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Sidebar toggle for mobile
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
                if (window.innerWidth > 768) {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('collapsed');
                }
            });
        });
    </script>
</body>

</html>
