<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    margin: 0;
    background-color: #f0f0f0; /* Light gray background for the page */
}

.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0px;
    left: 0;
    background: #800000; /* Maroon color for sidebar */
    padding-top: 0px;
    transition: transform 0.3s ease-in-out;
    z-index: 1000;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}

.sidebar.collapsed {
    transform: translateX(-100%);
}

.sidebar-toggle {
    position: absolute;
    top: 50%;
    right: -30px;
    transform: translateY(-50%);
    background: #c2241d; /* Maroon color for toggle button */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    z-index: 1001;
    transition: right 0.3s ease-in-out;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar.collapsed ~ .sidebar-toggle {
    right: 0;
}

.sidebar-toggle svg {
    width: 24px;
    height: 24px;
    fill: white; /* White color for SVG icon */
}

.sidebar-content {
    flex: 1;
    padding: 16px;
}

.sidebar-content .toggle-label {
    display: none;
}

.sidebar.collapsed .toggle-label {
    display: block;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    margin-top: 0;
    transition: margin-left 0.3s ease-in-out;
    background-color: #f0f0f0; /* Light gray background for main content */
}

.main-content.collapsed {
    margin-left: 0;
}



    </style>
    
</head>
<body>

    <div id="sidebar" class="sidebar">
        <div class="sidebar-content">
            @include('layouts.sidebar')
            <button id="toggle-sidebar" class="sidebar-toggle">
                <span class="toggle-label">Hide</span>
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </div>
    </div>

    <div class="main-content" id="main-content">
        @yield('content')
        @stack('scripts')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Retrieve the saved state from localStorage
            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'collapsed') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            }

            document.getElementById('toggle-sidebar').addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');

                // Save the current state in localStorage
                if (sidebar.classList.contains('collapsed')) {
                    localStorage.setItem('sidebarState', 'collapsed');
                } else {
                    localStorage.setItem('sidebarState', 'expanded');
                }
            });
        });
    </script>

</body>
</html>
