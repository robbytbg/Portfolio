<!-- resources/views/layouts/sidebar.blade.php -->
<div id="sidebar" class="bg-maroon text-white w-64 min-h-screen fixed top-0 left-0 transition-transform duration-300 ease-in-out">
    <div class="p-4">
        <!-- Menu Buttons and Form -->
        <div class="button-menu p-3 bg-light-gray rounded">
            @can('admin user sheet')
            <a href="{{ route('user_sheet.adminpage') }}" class="btn btn-light text-left {{ request()->routeIs('user_sheet.adminpage') ? 'active' : '' }}">
                Admin Page
            </a>
            @endcan
            <a href="{{ route('user_sheet.dashboard') }}" class="btn btn-light text-left {{ request()->routeIs('user_sheet.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <button class="btn btn-toggle" id="toggleButton">
                Sheet Codes
            </button>
            
            <div id="sheetCodeContainer" class="sheet-code-container hidden">
                <a class="btn btn-sheet-code {{ !request('sheet_code') ? 'active' : '' }}" 
                   href="{{ route('user_sheet.index') }}">
                    Show All
                </a>
                @foreach($sheetCodes as $code)
                    <a class="btn btn-sheet-code {{ request('sheet_code') == $code ? 'active' : '' }}" 
                       href="{{ route('user_sheet.index', ['sheet_code' => $code] + request()->except('sheet_code')) }}">
                        {{ $code }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('homee') }}" class="btn btn-light text-left {{ request()->routeIs('homee') ? 'active' : '' }}">
                Guide
            </a>
        </div>


        
    </div>

    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem; background-color: whitesmoke; border: 1px solid grey; transition: background-color 0.3s ease; margin-left:25px; margin-right:25px">
        {{ Auth::user()->name }}
    </a>
    
    <!-- Dropdown Menu -->
    <div class="dropdown-menu-container" style="background-color: lightgrey; border-radius: 0.25rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 1rem; margin-top: 0.5rem; position: absolute; top: 100%; left: 50%; transform: translateX(-50%);">
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="list-style: none; padding: 0; margin: 0;">
            <li>
                <div class="sidebar-content" style="padding: 1rem; background-color: #e9ecef; border-radius: 0.25rem; margin-top: 0.5rem; color: #333;">
                    <strong>Your Roles:</strong>
                    @if($userRoles->isEmpty())
                        <span>No Roles</span>
                    @else
                        {{ $userRoles->join(', ') }}
                    @endif
                </div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}" style="color: black; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.25rem; display: block; transition: background-color 0.3s ease;">
                    {{ __('Profile') }}
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 0.5rem;">
                    @csrf
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #dc3545; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.25rem; display: block; transition: background-color 0.3s ease;">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </li>
        </ul>
    </div>
    
    

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleButton');
        const sheetCodeContainer = document.getElementById('sheetCodeContainer');
        
        // Function to get URL parameter by name
        function getUrlParameter(name) {
            const regex = new RegExp('[?&]' + name + '=([^&#]*)');
            const results = regex.exec(window.location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Initialize the dropdown state based on the presence of sheet_code parameter
        const sheetCodeParam = getUrlParameter('sheet_code');
        
        if (sheetCodeParam) {
            sheetCodeContainer.classList.remove('hidden');
            toggleButton.classList.add('active');
        } else {
            sheetCodeContainer.classList.add('hidden');
            toggleButton.classList.remove('active');
        }

        // Toggle button click event
        toggleButton.addEventListener('click', function() {
            if (sheetCodeContainer.classList.contains('hidden')) {
                sheetCodeContainer.classList.remove('hidden');
                localStorage.setItem('sheetCodeContainerOpen', 'true');
                toggleButton.classList.add('active');
                
                // Redirect to the "Show All" route
                window.location.href = "{{ route('user_sheet.index') }}";
            } else {
                sheetCodeContainer.classList.add('hidden');
                localStorage.setItem('sheetCodeContainerOpen', 'false');
                toggleButton.classList.remove('active');
            }
        });

        // Click outside the container to close it
        document.addEventListener('click', function(event) {
            if (!sheetCodeContainer.contains(event.target) && !toggleButton.contains(event.target)) {
                sheetCodeContainer.classList.add('hidden');
                localStorage.setItem('sheetCodeContainerOpen', 'false');
                toggleButton.classList.remove('active');
            }
        });

        // Restore state from localStorage
        if (localStorage.getItem('sheetCodeContainerOpen') === 'true') {
            sheetCodeContainer.classList.remove('hidden');
            toggleButton.classList.add('active');
        } else {
            sheetCodeContainer.classList.add('hidden');
            toggleButton.classList.remove('active');
        }
    });
</script>



<style>
    /* Sidebar background color */
    #sidebar {
        background-color: #c2241d; /* Maroon color */
    }
    .btn.active{
        background-color: #c2241d; /* Maroon background */
        color: white; /* White text color */
        border: 1px solid black; /* Black border */
    }
    .button-menu {
        background-color: #f0f0f0; /* Light gray background for button menu */
        border-radius: 0; /* Squared corners */
        border: 1px solid #8a8a8a; /* Border for button menu */
        position: relative; /* Ensure the dropdown is positioned relative to this container */
    }

    .btn-light {
        display: block;
        width: 100%;
        text-align: left;
        background-color: #b0b0b0; /* Darker light gray background for buttons */
        color: #333; /* Darker text color for contrast */
        border: 1px solid #8a8a8a; /* Darker gray border */
        border-radius: 0; /* Squared corners */
        padding: 0.5rem; /* Padding inside the button */
        margin-top: 0.5rem; /* Margin between buttons */
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-light:hover {
        background-color: #a0a0a0; /* Slightly darker gray on hover */
        border-color: #7a7a7a; /* Darker border on hover */
    }

    .btn-toggle {
        display: block;
        width: 100%;
        text-align: left;
        background-color: #b0b0b0; /* Darker light gray background for the toggle button */
        color: #333; /* Darker text color for contrast */
        border: 1px solid #8a8a8a; /* Darker gray border */
        border-radius: 0; /* Squared corners */
        padding: 0.75rem; /* Padding inside the toggle button */
        margin-top: 0.5rem; /* Margin between the toggle button and sheet code buttons */
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-toggle:hover {
        background-color: #a0a0a0; /* Slightly darker gray on hover */
        border-color: #7a7a7a; /* Darker border on hover */
    }

    /* Active button style */
    .btn-toggle.active {
        background-color: #c2241d; /* Maroon background */
        color: white; /* White text color */
        border: 1px solid black; /* Black border */
    }

    .sheet-code-container {
        background-color: #ffffff; /* White background for sheet code container */
        padding: 0.5rem;
        border-radius: 0; /* Squared corners */
        margin-top: 0.5rem;
        max-height: 12rem; /* Maximum height for the container */
        overflow-y: auto; /* Enable vertical scrolling if content exceeds max height */
    }

    .btn-sheet-code {
        background-color: #d0d0d0; /* Light gray background for sheet code buttons */
        color: #333; /* Darker text color for contrast */
        border: 1px solid #8a8a8a; /* Darker gray border */
        border-radius: 0; /* Squared corners */
        padding: 0.5rem; /* Padding inside sheet code buttons */
        margin-top: 0.25rem; /* Margin between sheet code buttons */
        transition: background-color 0.3s, border-color 0.3s;
        text-align: left;
        display: block;
        width: 100%;
    }

    .btn-sheet-code:hover {
        background-color: #c0c0c0; /* Slightly darker gray on hover */
        border-color: #7a7a7a; /* Darker border on hover */
    }

    .btn-sheet-code.active {
        background-color: #c2241d; /* Red background for active sheet code button */
        color: white; /* White text color */
        border-color: black; /* Black border */
    }

    /* Utility class for hiding elements */
    .hidden {
        display: none;
    }
</style>
