<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
</head>
<body style="background-color: #f1f0f1" >
    <div class="page-wrapper">
        
<div class="py-12 card-container" style="min-width: 90%">
    <div class="button-container absolute top-4 right-4 flex items-center">
        <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
            <div class="btn-group" role="group" style="border: 0;">
                <!-- User Name Display -->
                <div class="user-name text-white px-3 py-1.5 text-sm" style="background-color: #b0b0b0; border-radius: 10px 0 0 0px; border-right: 1px solid #c3251d;">
                    {{ Auth::user()->name }}
                </div>
                @csrf
                <!-- Logout Button -->
                <button 
                    type="submit"
                    class="text-white px-3 py-1.5 text-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-300"
                    style="background-color: #c3251d; border-radius: 0 10px 0px 0; border: none;"
                >
                    {{ __('Log Out') }}
                </button>
            </div>
        </form>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
        <div class="bg-white shadow-lg rounded-lg overflow-hidden" style="border-radius:0" >
            <div class="card-header relative" style="background-color: #f9f9f8; border-radius: 0; border: solid 1px #d4d5d4; padding: 1rem;">
                <h4 class="text-xl font-semibold mb-0" style="color: black;">User Management Page</h4>
                
                

            </div>
            
            

            <div class="card-body bg-light-gray" style="background-color:#fefeff;border:solid 1px #d4d5d4">
                @if(session('success'))
                <div id="success-alert" class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="me-2 text-success"><path d="M22 12l-10-10-10 10h20z"/></svg>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            

            
                <!-- Search Form -->
<!-- Search Form -->
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 d-flex align-items-center" >
    <input
        type="text"
        name="email"
        placeholder="Search by email"
        class="form-control me-2"
        value="{{ request('email') }}"
        style="flex: 1; border-radius: 0%"
    />

    <select name="role" class="form-select me-2" style="flex: 1; border-radius: 0%;">
        <option value="">Select Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <div class="btn-group" role="group" style="border: 0ch">
        <button type="submit" class="btn btn-primary" style="border-radius: 0%; border: 0ch; background-color:#b0b0b0">Search</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="border-radius: 0%; border: 0;background-color:#c3251d">Reset</a>
    </div>
    
</form>




                <!-- User list -->
                <div class="overflow-x-auto">
                    <table class="min-w-full" >
                        <thead>
                            <tr>
                                <th class="border">Name</th>
                                <th class="border">Email</th>
                                <th class="border">Roles</th>
                                <th class="border">Assign Role</th>
                                <th class="border">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><span>{{ $user->name }}</span></td>
                                <td><span>{{ $user->email }}</span></td>
                                <td class="button-cell roles-column" style="max-width: 300px; min-width:300px">
                                    <div class="roles-list">
                                        @if($user->getRoleNames()->isEmpty())
                                            <span class="no-roles">No Roles</span>
                                        @else
                                            @foreach($user->roles as $role)
                                                <form method="POST" action="{{ route('admin.users.remove-role', [$user, $role]) }}" class="role-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <span class="role-badge">
                                                        {{ $role->name }} 
                                                        <button type="submit" class="remove-role-btn">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 1024 1024" fill="#c3251d"><path d="M512 897.6c-108 0-209.6-42.4-285.6-118.4-76-76-118.4-177.6-118.4-285.6 0-108 42.4-209.6 118.4-285.6 76-76 177.6-118.4 285.6-118.4 108 0 209.6 42.4 285.6 118.4 157.6 157.6 157.6 413.6 0 571.2-76 76-177.6 118.4-285.6 118.4z m0-760c-95.2 0-184.8 36.8-252 104-67.2 67.2-104 156.8-104 252s36.8 184.8 104 252c67.2 67.2 156.8 104 252 104 95.2 0 184.8-36.8 252-104 139.2-139.2 139.2-364.8 0-504-67.2-67.2-156.8-104-252-104z" /><path d="M707.872 329.392L348.096 689.16l-31.68-31.68 359.776-359.768z" /><path d="M328 340.8l32-31.2 348 348-32 32z" /></svg>
                                                        </button>
                                                    </span>
                                                </form>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="button-cell center-content" style="padding-top:15px;padding-bottom:-20px">
                                    <form method="POST" action="{{ route('admin.users.assign-role', $user) }}" class="assign-role-form">
                                        @csrf
                                        <div class="input-group">
                                            <select name="role" required class="form-select" style="background-color: #b0b0b0; color: white; border-radius: 0%; font-size: 14px;">
                                                <option value="" disabled selected>Assign Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <button type="submit" class="btn" style="border: solid 1px #b0b0b0; background-color: #b0b0b0; box-shadow: inset 0 0 0 2px #f3f2f3;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24">
                                                    <path d="M24 9h-9v-9h-6v9h-9v6h9v9h6v-9h9z" fill="#f3f2f3"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="button-cell center-content" style="padding-top:15px;padding-bottom:-20px">
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this item?');">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #c3251d !important;">
                                                <path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="pagination-container mt-4">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function () {
                successAlert.style.opacity = 0;
                successAlert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(function () {
                    successAlert.style.visibility = 'hidden'; // Remove visibility after fade-out
                    successAlert.style.height = '0'; // Adjust height to zero
                    successAlert.style.padding = '0'; // Remove padding
                }, 500); // Matches the transition duration
            }, 5000); // 5 seconds
        }
    });
</script>



</body>

<style>
/* Page Wrapper */
.page-wrapper {
    width: 80%;
    margin: 20px auto; /* 20px top and bottom margin, centered horizontally */
    padding: 20px; /* Padding around the content */
}

/* Card Container */
.card-container {
    background-color: #ffffff;
    border-radius: 8px; /* Rounded corners for the card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for the card */
    padding: 20px; /* Padding inside the card */
    border: 1px solid #d4d5d4; /* Border color */
    margin-bottom: 20px; /* Margin below the card */
}

/* Card Header Styles */
.card-header {
    background-color: #4a5568; /* Dark gray background */
    border-bottom: 2px solid #2d3748; /* Darker gray border */
    padding: 16px 24px; /* Padding around the header */
    display: flex;
    justify-content: center; /* Center the title horizontally */
    align-items: center; /* Center the title vertically */
    position: relative; /* Position relative for absolute children */
}

.card-header h4 {
    margin: 0; /* Remove default margin */
    font-size: 1.5rem; /* Larger font size */
    color: #ffffff; /* White text color */
}

/* Card Body Styles */
.card-body {
    padding: 24px; /* Add padding around the body */
    background-color: #f7fafc; /* Light gray background */
    max-height: 400px; /* Maximum height for the card body */
    overflow-y: auto; /* Vertical scrolling if content exceeds max height */
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Header Styles */
thead th {
    background-color: #fefeff;
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center; /* Center align text in the header */
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide overflowing content */
    text-overflow: ellipsis; /* Show ellipses for truncated text */
    max-width: 150px; /* Set maximum width for header cells */
}

/* Cell Styles */
tbody td {
    border: 1px solid #ddd;
    padding: 15px; /* Padding inside cells */
    text-align: center; /* Center align text in cells */
    white-space: nowrap; /* Prevent text from wrapping */
    overflow: hidden; /* Hide overflowing content */
    text-overflow: ellipsis; /* Show ellipses for truncated text */
    max-width: 150px; /* Set maximum width for cells */
}

/* Specific Styles for Roles Column */
.roles-list {
    display: flex;
    flex-wrap: nowrap; /* Keep roles in a single row */
    gap: 8px; /* Horizontal gap between roles */
    padding: 0; /* Remove padding */
    margin-top: 8px; /* Add top margin */
    margin-bottom: -8px; /* Adjust bottom margin to shift up */
    align-items: center; /* Center items vertically within the row */
    justify-content: center; /* Center items horizontally within the cell */
    overflow: hidden; /* Hide overflowing content */
    text-overflow: ellipsis; /* Show ellipses for truncated text */
}

/* Role Badge Styles */
.role-badge {
    background-color: #b0b1b1;
    border: 1px solid #b0b1b1;
    border-radius: 4px;
    padding: 4px 8px;
    display: flex;
    align-items: center;
    justify-content: center; /* Center badge content horizontally */
    color: white;
}

/* Remove Role Button */
.remove-role-btn {
    padding: 0%;
    background: none;
    border: none;
    color: #c3251d;
    cursor: pointer;
    margin-left: 4px;
    display: flex; /* Use flexbox */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
    font-size: 1.2rem;
    border-radius: 180%; /* Optional: Add rounded corners */
}

/* No Roles Message */
.no-roles {
    margin-top: 10px;
    margin-bottom: 20px;
    color: #718096;
}

/* Button and Dropdown Styles */
.button-cell {
    padding: 0; /* Remove padding from cells */
    margin: 0; /* Remove margin from cells */
    padding-left: 5px; /* Adjust padding left */
    padding-right: 5px; /* Adjust padding right */
}

/* No Gap Between Buttons in Forms */
.assign-role-form, .inline-form, .role-form {
    display: flex;
    align-items: center; /* Center items vertically */
    justify-content: center; /* Center items horizontally */
    width: 100%; /* Full width to fit the cell */
    height: 100%; /* Full height to fit the cell */
    box-sizing: border-box; /* Ensure padding and border are included in width/height */
    gap: 0; /* No gap between buttons */
}

/* Remove Padding and Margin for Buttons */
.select-role, .assign-button, .remove-button, .delete-button {
    border: 1px solid #ccc;
    padding: 4px 8px;
    background-color: #f7fafc;
    cursor: pointer;
    font-size: 0.875rem; /* Slightly smaller font size */
    margin: 0; /* Remove default margin */
    box-sizing: border-box; /* Include padding in width */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px; /* Add gap between icon and text */
}

/* Specific Styles for Buttons */
.assign-button {
    background-color: #4299e1;
    color: white;
}

/* Styling for Dropdown and Button to be Side by Side */
.select-role {
    width: auto; /* Adjust width as needed */
    margin-right: 4px; /* Add some space between the dropdown and the button */
}

/* Icon Styles */
.assign-button svg, .remove-role-btn svg {
    width: 1em; /* Ensure SVG fits within the button */
    height: 1em;
    fill: currentColor; /* Match the icon color with the button text color */
}

/* Responsive Design */
@media (max-width: 640px) {
    .roles-list {
        gap: 4px;
        margin-bottom: -4px; /* Adjust bottom margin for smaller screens */
    }

    .assign-button, .delete-button, .select-role {
        font-size: 0.75rem; /* Smaller font size for smaller screens */
        padding: 2px 4px; /* Adjust padding for smaller screens */
    }
}

/* Logout Button Container */
.card-header form {
    position: absolute; /* Absolute positioning within the header */
    top: 16px; /* Adjust top spacing */
    right: 16px; /* Adjust right spacing */
}

/* Delete Button (for reference) */
.delete-button {
    background: none; /* Remove background color */
    border: none; /* Remove border */
    padding: 0; /* Remove padding */
    margin: 0; /* Remove margin */
    cursor: pointer; /* Ensure the cursor changes to a pointer on hover */
    outline: none; /* Remove any outline */
    color: inherit; /* Ensure SVG uses the button's text color */
}

.delete-button svg {
    fill: currentColor; /* SVG color matches the button text color */
    stroke: none; /* Ensure there's no stroke (outline) */
}

/* Enhanced Success Message Styling */
.alert-success {
    background-color: #d4edda; /* Light green background */
    border-color: #c3e6cb; /* Slightly darker green border */
    color: #155724; /* Dark green text */
    border-radius: 0.375rem; /* Rounded corners */
    padding: 1rem; /* Increased padding */
    box-shadow: 0 0 0.125rem rgba(0, 0, 0, 0.1); /* Subtle shadow */
    display: flex; /* Flexbox for alignment */
    align-items: center; /* Center items vertically */
}

.alert-success svg {
    fill: #28a745; /* Green color for the icon */
}

.alert-success .alert-content {
    margin-left: 0.5rem; /* Space between icon and text */
    font-size: 1rem; /* Standard font size */
}

.alert-success .alert-close {
    margin-left: auto; /* Push close button to the right */
    background: none; /* No background */
    border: none; /* No border */
    color: #155724; /* Match text color */
    cursor: pointer; /* Pointer cursor */
    font-size: 1.25rem; /* Larger font size */
    line-height: 1; /* Adjust line height */
}

/* Initial State of the Alert */
#success-alert {
    opacity: 1; /* Fully visible */
    transition: opacity 0.5s ease-out, height 0.5s ease-out, padding 0.5s ease-out; /* Smooth transition */
    display: block; /* Ensure it's displayed initially */
    visibility: visible; /* Initially visible */
    height: auto; /* Default height */
    padding: 10px; /* Default padding */
}

/* Hidden State of the Alert */
.hidden-alert {
    opacity: 0; /* Fully transparent */
    height: 0; /* No height */
    padding: 0; /* No padding */
    visibility: hidden; /* Hidden visibility */
}
/* Style for odd rows */
tr:nth-child(odd) {
    background-color: #f3f2f3; /* Light gray color */
}

/* Style for even rows */
tr:nth-child(even) {
    background-color: white; /* White color */
}
</style>