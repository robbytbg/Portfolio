@extends('user_sheet.layouts')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div id="leaveNotification" class="alert alert-warning" style="display: none;">
    All query parameters will be reset. Are you sure you want to leave?
</div>

<div class="card mt-4 mx-auto" style="max-width: 180vh;">
    <div class="card-body row">
        <!-- Manage Sheet Codes Card -->
        <div class="col-md-6" style="margin-top: -1.5rem">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Manage Sheet Codes</h5>
                </div>
                <div class="card-body d-flex">
                    <!-- Flex container for inner elements -->
                    <div class="row w-100 d-flex">
                        <div class="col-md-6">
                            <!-- Scrollable List of Sheet Codes -->
                            <div class="mb-3">
                                <label for="sheetCodeList" class="form-label" style="margin-top: 0">Please Select:</label>
                                <div class="scrollable-list" style="border:1mm solid lightgrey; border-radius:8px">
                                    <ul class="list-group" id="sheetCodeList">
                                        @foreach($codes as $index => $code)
                                            <li class="list-group-item" data-code="{{ $code }}" data-count="{{ $counts[$index] }}">
                                                {{ $code }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Card for Selected Sheet Code Info -->
                            <div class="card mb-3 flex-grow-1">
                                <div class="card-body">
                                    <p><strong>Selected :</strong> <span id="selectedSheetCode">-</span></p>
                                    <p><strong>Count:</strong> <span id="selectedCount">-</span></p>
                                </div>
                            </div>

                            <!-- Action Buttons and Forms in a Card -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-primary w-100 me-2" id="editButton">Edit</button>
                                    
                                        <!-- Delete Form -->
                                        <form id="deleteForm" action="{{ route('user_sheet.adminpage.delete', '') }}" method="POST" class="mt-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100" id="deleteButton" onclick="return confirm('Are you sure you want to delete this sheet code?');">Delete</button>
                                        </form>
                                    </div>
                                    
                                                                        <!-- Edit Form -->
                                    <div id="editFormContainer" class="card mt-3" style="display: none; padding:10px">
                                        <form id="editForm" action="{{ route('user_sheet.adminpage.update', '') }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group flex-grow-1 me-2">
                                                <label for="new_sheet_code">New Sheet Code</label>
                                                <input type="text" name="new_sheet_code" id="new_sheet_code" class="form-control" required>
                                                <input type="hidden" name="sheet_code" id="editSheetCode">
                                            </div>
                                            <button type="submit" class="btn btn-primary" style="height:40px; margin-top:23px">Save</button>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            <!-- Notification -->
                            <div id="notification" class="alert alert-warning mt-3" style="display: none;">
                                Please select a sheet code before performing an action.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage SND Records Card -->
        <div class="col-md-6">
            <!-- New Card Below the Manage SND Records Card -->
<div class="card" style="margin-bottom: 1.2rem">

    <div class="card-body">
        <!-- Button Actions and Other Content Here -->
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('user_sheet.create') }}" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center; flex: 1; font-size: 16px; padding: 10px; border-radius: 4px; background-color: #007bff; border-color: #007bff; text-decoration: none; color: #fff;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="width: 20px; height: 20px; margin-right: 8px;">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-5v5h-2v-5h-5v-2h5v-5h2v5h5v2z"/>
                </svg>
                <span>Create New Entity</span>
            </a>

            <a href="{{ route('user_sheet.upload.form') }}" class="btn btn-secondary" style="display: flex; align-items: center; justify-content: center; flex: 1; font-size: 16px; padding: 10px; border-radius: 4px; background-color: #6c757d; border-color: #6c757d; text-decoration: none; color: #fff;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; margin-right: 8px;">
                    <path d="M13.5 3H12H8C6.34315 3 5 4.34315 5 6V18C5 19.6569 6.34315 21 8 21H12M13.5 3L19 8.625M13.5 3V7.625C13.5 8.17728 13.9477 8.625 14.5 8.625H19M19 8.625V11.8125" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.5 21L17.5 15M17.5 15L20 17.5M17.5 15L15 17.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Upload New sheetCode</span>
            </a>
        </div>
    </div>
</div>
            <div class="card mb-4" style="height: 12.60rem">
                <div class="card-header">
                    <h5>Manage SND Records</h5>
                </div>
                <div class="card-body">
                    <!-- Content for the Manage SND Records Card -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form id="searchForm" action="{{ route('user_sheet.adminpage.searchBySnd') }}" method="GET" class="d-flex w-100">
                                <div class="form-group flex-grow-1 me-2">
                                    <input type="text" name="snd" id="snd" class="form-control" placeholder="Search by SND" required>
                                </div>
                                <button type="submit" class="btn btn-primary" >Search</button>
                            </form>
                        </div>
                        
                    </div>
                    @if(isset($sndRecords) && !$sndRecords->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    @foreach($sndRecords as $record)
                                        <li class="list-group-item">
                                            {{ $record->snd }} - {{ $record->nama_cli }} - {{ $record->sheet_code }}
                                            <div class="d-flex justify-content-end" style="margin-top: -25px">
                                                <button class="btn btn-sm btn-warning edit-snd me-2" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editSndModal" 
                                                    data-snd="{{ $record->snd }}" 
                                                    data-sheet_code="{{ $record->sheet_code }}">
                                                    Edit
                                                </button>
                                            
                                                <form id="deleteForm" action="{{ route('user_sheet.adminpage.deleteSnd', ['snd' => $record->snd, 'sheet_code' => $record->sheet_code]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                                </form>
                                            </div>
                                            
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <p>No SND records found.</p>
                    @endif
                </div>
            </div>




        </div>
    </div>
</div>


<!-- Edit SND Modal -->
<div class="modal fade" id="editSndModal" tabindex="-1" aria-labelledby="editSndModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSndModalLabel">Edit SND Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <form id="editSndForm" action="{{ route('user_sheet.adminpage.update', '') }}" method="POST">
                @csrf
                @method('PUT')
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="customer-info-tab" data-bs-toggle="tab" data-bs-target="#customer-info" type="button" role="tab" aria-controls="customer-info" aria-selected="true">Edit Customer Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="editing-tab" data-bs-toggle="tab" data-bs-target="#editing" type="button" role="tab" aria-controls="editing" aria-selected="false">Edit Customer Status</button>
                    </li>
                </ul>
        
                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="customer-info" role="tabpanel" aria-labelledby="customer-info-tab">
                        <div class="row">
                            <div class="col-md-6 column-divider">
                                <!-- Customer Info Left Column -->                    
                                <div class="mb-3">
                        <label for="modal_nper" class="form-label">NPer</label>
                        <input type="text" name="nper" id="modal_nper" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_snd" class="form-label">SND</label>
                        <input type="text" name="snd" id="modal_snd" class="form-control" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_sheet_code" class="form-label">Sheet Code</label >
                        <input type="text" name="sheet_code" id="modal_sheet_code" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="modal_snd_group" class="form-label">SND Group</label>
                        <input type="text" name="snd_group" id="modal_snd_group" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_nama_cli" class="form-label">Nama CLI</label>
                        <input type="text" name="nama_cli" id="modal_nama_cli" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="modal_alamat" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_ubis" class="form-label">UBIS</label>
                        <input type="text" name="ubis" id="modal_ubis" class="form-control" >
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Customer Info Right Column -->
                    <div class="mb-3">
                        <label for="modal_desc_newbill" class="form-label">Description New Bill</label>
                        <input type="text" name="desc_newbill" id="modal_desc_newbill" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_usage_desc" class="form-label">Usage Description</label>
                        <input type="text" name="usage_desc" id="modal_usage_desc" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_lama_berlangganan" class="form-label">Lama Berlangganan</label>
                        <input type="text" name="lama_berlangganan" id="modal_lama_berlangganan" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_saldo" class="form-label">Saldo</label>
                        <input type="text" name="saldo" id="modal_saldo" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" id="modal_no_hp" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_email" class="form-label">Email</label>
                        <input type="email" name="email" id="modal_email" class="form-control" >
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="editing" role="tabpanel" aria-labelledby="editing-tab">
            <div class="row">
                <div class="col-md-6 column-divider">
                    <!-- Customer Edit Status Left Column -->
                    <div class="mb-3">
                        <label for="modal_tanggal_caring_1" class="form-label">Tanggal Caring 1</label>
                        <input type="date" name="tanggal_caring_1" id="modal_tanggal_caring_1" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_petugas" class="form-label">Petugas</label>
                        <input type="text" name="petugas" id="modal_petugas" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_status" class="form-label">Status</label>
                        <select name="status" id="modal_status" class="form-control" >
                            <option value="" disabled selected>Select a status</option>
                            <option value="JAWAB OKE">JAWAB OKE</option>
                            <option value="LUNAS/PAID">LUNAS/PAID</option>
                            <option value="RNA">RNA</option>
                            <option value="TIDAK AKTIF">TIDAK AKTIF</option>
                            <option value="REJECT">REJECT</option>
                            <option value="COMPLAIN">COMPLAIN</option>

                        </select>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Customer Edit Status Right Column -->
                    <div class="mb-3">
                        <label for="modal_tanggal_caring_2" class="form-label">Tanggal Caring 2</label>
                        <input type="date" name="tanggal_caring_2" id="modal_tanggal_caring_2" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_petugas_2" class="form-label">Petugas 2</label>
                        <input type="text" name="petugas_2" id="modal_petugas_2" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="modal_status_2" class="form-label">Status 2</label>
                        <select name="status_2" id="modal_status_2" class="form-control" >
                            <option value="" disabled selected>Select a status</option>
                            <option value="JAWAB OKE">JAWAB OKE</option>
                            <option value="LUNAS/PAID">LUNAS/PAID</option>
                            <option value="RNA">RNA</option>
                            <option value="TIDAK AKTIF">TIDAK AKTIF</option>
                            <option value="REJECT">REJECT</option>
                            <option value="COMPLAIN">COMPLAIN</option>
                        </select>
                        
                    </div>
                    <div class="mb-3">
                        <label for="modal_additional_info" class="form-label">Additional Info</label>
                        <textarea name="additional_info" id="modal_additional_info" class="form-control" ></textarea>
                    </div>
                    <input type="hidden" name="id" id="modal_id">
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
            </form>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('editSndModal'));
    var editSndButtons = document.querySelectorAll('.edit-snd');
    var editSndForm = document.getElementById('editSndForm');
    var modalFields = {
        nper: document.getElementById('modal_nper'),
        snd: document.getElementById('modal_snd'),
        sheet_code: document.getElementById('modal_sheet_code'),
        snd_group: document.getElementById('modal_snd_group'),
        nama_cli: document.getElementById('modal_nama_cli'),
        alamat: document.getElementById('modal_alamat'),
        ubis: document.getElementById('modal_ubis'),
        desc_newbill: document.getElementById('modal_desc_newbill'),
        usage_desc: document.getElementById('modal_usage_desc'),
        lama_berlangganan: document.getElementById('modal_lama_berlangganan'),
        saldo: document.getElementById('modal_saldo'),
        no_hp: document.getElementById('modal_no_hp'),
        email: document.getElementById('modal_email'),
        tanggal_caring_1: document.getElementById('modal_tanggal_caring_1'),
        petugas: document.getElementById('modal_petugas'),
        status: document.getElementById('modal_status'),
        tanggal_caring_2: document.getElementById('modal_tanggal_caring_2'),
        petugas_2: document.getElementById('modal_petugas_2'),
        status_2: document.getElementById('modal_status_2'),
        additional_info: document.getElementById('modal_additional_info'),
        id: document.getElementById('modal_id')
    };

    // Handle Edit SND button click
    editSndButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var snd = this.getAttribute('data-snd');
            var sheetCode = this.getAttribute('data-sheet_code');

            // Fetch record using AJAX
            fetch(`/user_sheet/adminpage/edit/${snd}/${sheetCode}`)
                .then(response => response.json())
                .then(data => {
                    // Check if data is returned and populate fields
                    if (data) {
                        Object.keys(modalFields).forEach(key => {
                            if (data[key] !== undefined) {
                                modalFields[key].value = data[key];
                            }
                        });

                        // Update the form action dynamically
                        editSndForm.action = `/user_sheet/adminpage/update/${snd}/${sheetCode}`;

                        // Show the modal
                        modal.show();
                    } else {
                        console.error('No data returned from the server.');
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
});





    var selectedSheetInfo = document.getElementById('selectedSheetInfo');
    var actionButtons = document.getElementById('actionButtons');
    var selectedSheetCode = document.getElementById('selectedSheetCode');
    var selectedCount = document.getElementById('selectedCount');
    var deleteForm = document.getElementById('deleteForm');
    var editFormContainer = document.getElementById('editFormContainer');
    var editButton = document.getElementById('editButton');
    var deleteButton = document.getElementById('deleteButton');
    var notification = document.getElementById('notification');
    var editSheetCode = document.getElementById('editSheetCode');

    // Default values
    selectedSheetCode.innerText = '-';
    selectedCount.innerText = '-';
    
    
    document.querySelectorAll('.list-group-item').forEach(function(item) {
    item.addEventListener('click', function() {
        var code = this.getAttribute('data-code');
        var count = this.getAttribute('data-count');

        selectedSheetCode.innerText = code;
        selectedCount.innerText = count;

        var editFormAction = "{{ route('user_sheet.adminpage.update', '') }}";
        document.getElementById('editForm').action = editFormAction + '/' + encodeURIComponent(code);
            // Set form action for editing
        // Set form action for deletion
        var deleteFormAction = "{{ route('user_sheet.adminpage.delete', '') }}";
        document.getElementById('deleteForm').action = deleteFormAction + '/' + encodeURIComponent(code);

        editSheetCode.value = code;
    });
});

// Show/hide update form when 'Edit' button is clicked
editButton.addEventListener('click', function() {
    // Check if the edit form is currently visible
    if (editFormContainer.style.display === 'block') {
        // If it's visible, hide it
        editFormContainer.style.display = 'none';
    } else {
        // If it's hidden, check the selectedSheetCode
        if (selectedSheetCode.innerText === '-') {
            notification.style.display = 'block'; // Show notification if no sheet is selected
        } else {
            editFormContainer.style.display = 'block'; // Show the edit form
            notification.style.display = 'none'; // Hide notification
        }
    }
});


</script>
<!-- Inline CSS or in your stylesheet -->
<style>
    .scrollable-list {
        max-height: 200px; /* Adjust height as needed */
        overflow-y: auto; /* Enables vertical scrolling */
        border: 1px solid #ddd; /* Optional: Adds a border around the scrollable area */
        padding: 0;
    }

    .scrollable-list ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
</style>
@endsection
