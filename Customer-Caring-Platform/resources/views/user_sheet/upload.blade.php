@extends('user_sheet.layouts')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')

<div class="container mt-4">
    <!-- Card for File Upload -->
    <div class="card">
        
        <div class="card-header">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Upload User Sheet</h4>
                <a href="{{ route('user_sheet.adminpage') }}" class="btn btn-danger" style="border-radius: 0; background-color:#c3241c;">Back</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="fileUploadForm" action="{{ route('user_sheet.file.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="file">Choose Excel File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            <small id="fileNameDisplay" class="form-text text-muted">
                                @if(session('fileName'))
                                    Selected File: {{ session('fileName') }}
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="sheet_code">Sheet Code</label>
                            <input type="text" name="sheet_code" id="sheet_code" class="form-control" required value="{{ old('sheet_code', session('sheet_code')) }}">
                        </div>
                    </div>
                </div>
                <!-- Button Group Centered -->
                <div class="d-flex justify-content-center mt-3">
                    <div class="btn-group" role="group">
                        <button type="submit" name="action" value="preview" class="btn btn-info" style="background-color: #f0f0f0; border:0;border-radius: 10px 0px 0px 0px; margin-right: 10px;">Preview</button>
                        <button type="submit" name="action" value="upload" class="btn btn-primary" style="color:black;background-color: #b0b0b0; border: 0;border-radius: 0px 10px 0px 0px;">Upload</button>
                    </div>
                </div>
            </form>
                       <!-- Reset Button Outside the Form -->
    <div class="d-flex justify-content-center mt-4">
        <button id="resetButton" class="btn btn-warning" style=";background-color: #c3241c;color:white; border: 0; border-radius: 0px 0px 10px 10px; margin-top:-15px; width:163px">Reset</button>
    </div>
        </div>
 
    </div>

    <!-- Card for Data Preview -->
    @if(session('preview') && session('preview') == true && session('previewData'))
        <div class="card mt-4">
            <div class="card-header">
                <h4>Uploaded Data Preview</h4>
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @if(isset(session('previewData')[0][0]) && is_array(session('previewData')[0][0]))
                                        @foreach(session('previewData')[0][0] as $header)
                                            <th>{{ htmlspecialchars($header, ENT_QUOTES, 'UTF-8') }}</th>
                                        @endforeach
                                    @else
                                        <th>No Headers Found</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('previewData')[0] as $row)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td>{{ htmlspecialchars($cell, ENT_QUOTES, 'UTF-8'); }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>No preview data available.</p>
    @endif
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle file input change
        document.getElementById('file').addEventListener('change', function(event) {
            const fileName = event.target.files[0] ? event.target.files[0].name : '';
            document.getElementById('fileNameDisplay').textContent = `Selected File: ${fileName}`;
        });

        // Handle reset button click
        document.getElementById('resetButton').addEventListener('click', function() {
            // Create a form element
            const form = document.getElementById('fileUploadForm');

            // Set the action to "reset"
            const inputAction = document.createElement('input');
            inputAction.type = 'hidden';
            inputAction.name = 'action';
            inputAction.value = 'reset';
            form.appendChild(inputAction);

            // Submit the form
            form.submit();
        });
    });
</script>

<style>
    .table tbody tr:first-child {
        display: none;
    }
    .table-wrapper {
        position: relative;
        width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa; /* Adjust to match your card header color */
        z-index: 1;
    }

    .table td, .table th {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px; /* Adjust the max-width as needed */
    }
    tr:nth-child(odd) {
        background-color: #f3f2f3; /* Light gray color */
    }

    /* Style for even rows */
    tr:nth-child(even) {
        background-color: white; /* White color */
    }
    .btn-group {
        display: flex;
        gap: -10px; /* Adjust the spacing between buttons */
    }

    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }
    .card-header {
        padding: 0.5rem 0.25rem;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }

    .card-header h4 {
        margin: 0;
    }
</style>
@endsection
