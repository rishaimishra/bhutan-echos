<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Bhutan Echos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 1rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover {
            color: rgba(255,255,255,1);
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        .sidebar .nav-link p {
            margin: 0;
        }
        .main-content {
            transition: all 0.3s;
        }
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: #343a40;
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                width: 250px;
            }
            .sidebar.show {
                left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            .main-content {
                margin-left: 0 !important;
            }
            .main-content.sidebar-open {
                margin-left: 250px !important;
            }
        }
        .nav-item {
            width: 100%;
        }
        .nav-item form {
            width: 100%;
        }
        .nav-item button {
            padding: 1rem;
            width: 100%;
            text-align: left;
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar" id="sidebar">
                <div class="p-3">
                    <h4 class="text-white">Admin Panel</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.live-sessions.*') ? 'active' : '' }}" href="{{ route('admin.live-sessions.index') }}">
                            <i class="fas fa-video"></i> Live Sessions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.live-questions.*') ? 'active' : '' }}" href="{{ route('admin.live-questions.index') }}">
                            <i class="fas fa-question-circle"></i> Live Questions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.live-polls.index') }}" class="nav-link {{ request()->routeIs('admin.live-polls.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-poll"></i>
                            <p>Live Polls</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comment-alt"></i>
                            <p>Feedback</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.tributes.index') }}" class="nav-link {{ request()->routeIs('admin.tributes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-heart"></i>
                            <p>Tribute Wall</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.timeline.index') }}" class="nav-link {{ request()->routeIs('admin.timeline.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Timeline</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.audio.index') }}" class="nav-link {{ request()->routeIs('admin.audio.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-music"></i>
                            <p>Royal Audio Series</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.ebooks.index') }}" class="nav-link {{ request()->routeIs('admin.ebooks.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>E-Books</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.quizzes.index') }}" class="nav-link {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Quizzes</p>
                        </a>
                    </li>
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Back to Site
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent text-white-50 w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-auto px-4 py-3 main-content" id="mainContent">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('sidebar-open');
            }

            sidebarToggle.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('sidebar-open');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('sidebar-open');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 