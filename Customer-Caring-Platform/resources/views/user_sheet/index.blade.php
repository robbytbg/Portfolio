@extends('user_sheet.layouts')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')



<head>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/trash.css' rel='stylesheet'>

    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/pen.css' rel='stylesheet'>
    <style>
        .form-group {
            position: relative;
        }
        .form-control {
            padding-right: 40px; /* Space for reset button */
        }
        .reset-button {
            position: absolute;
            right: 10px; /* Distance from the right edge */
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #6c757d;
        }
        .reset-button svg {
            width: 16px;
            height: 16px;
        }
        .btn-custom {
            width: 40px; /* Adjust width as needed */
            height: 40px; /* Adjust height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0rem;
        }
                
        .card-table-container {
            display: flex;
            flex-direction: column;
        }
        .card-table-container .card, 
        .card-table-container .table {
            flex: 1;
            width: 100%;
            border-radius: 0;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
        }
        .table td, .table th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px; /* Adjust the max-width as needed */
        }





    </style>

</head>

<div class="container">

    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card" style="border-radius: 0;">
                <div class="card-header">
                    <h4>{{ request()->query('sheet_code') }}
                    </h4>
                </div>

                <div class="card-body">
                    
                    <form action="{{ route('user_sheet.index') }}" method="GET" class="mb-3">
                        <input type="hidden" name="sheet_code" value="{{ request('sheet_code') }}">

                        <div class="d-flex align-items-center">
                            <!-- Search Container -->
                            <div class="search-container" style="position: relative; flex: 1;">
                                <input type="text" name="snd" class="form-control pe-5" placeholder="Search by Snd" style="padding-right: 40px; border-radius: 0;">
                                <button type="button" id="reset-search" class="btn btn-secondary" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: red; padding: 0; font-size: 16px; z-index: 10;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="fill: rgb(172, 168, 168);">
                                        <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
                                    </svg>
                                </button>
                            </div>
                    
                            <!-- Apply & Show Filters Buttons -->
                            <div class="ms-2 d-flex">
                                <button type="submit" class="btn btn-primary" style="border-radius: 0; margin-right: -1px; height: 38px; background-color: #b1b0b1; border: #b1b0b1; font-size: 14px;">
                                    Apply
                                </button>
                                <button class="btn btn-danger btn-sm" type="button" id="show-filters-btn" style="border-radius: 0; height: 38px; background-color: #c3241c; font-size: 14px;">
                                    Show Filters
                                </button>
                                <a href="{{ route('user_sheet.export', [
                                    'sheet_code' => request('sheet_code'),
                                    'snd' => request('snd'),
                                    'include_status' => request('include_status', []),
                                    'exclude_status' => request('exclude_status', []),
                                    'include_status_2' => request('include_status_2', []),
                                    'exclude_status_2' => request('exclude_status_2', [])
                                ]) }}" class="btn" style="display: flex; align-items: center; justify-content: center; text-decoration: none; color: #fff; background-color: #007bff; border: 1px solid #007bff; border-radius: 0; height: 38px; font-size: 14px; padding: 0 12px; font-weight: bold;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;">
                                        <path d="M5.625 15C5.625 14.5858 5.28921 14.25 4.875 14.25C4.46079 14.25 4.125 14.5858 4.125 15H5.625ZM4.875 16H4.125H4.875ZM19.275 15C19.275 14.5858 18.9392 14.25 18.525 14.25C18.1108 14.25 17.775 14.5858 17.775 15H19.275ZM11.1086 15.5387C10.8539 15.8653 10.9121 16.3366 11.2387 16.5914C11.5653 16.8461 12.0366 16.7879 12.2914 16.4613L11.1086 15.5387ZM16.1914 11.4613C16.4461 11.1347 16.3879 10.6634 16.0613 10.4086C15.7347 10.1539 15.2634 10.2121 15.0086 10.5387L16.1914 11.4613ZM11.1086 16.4613C11.3634 16.7879 11.8347 16.8461 12.1613 16.5914C12.4879 16.3366 12.5461 15.8653 12.2914 15.5387L11.1086 16.4613ZM8.39138 10.5387C8.13662 10.2121 7.66533 10.1539 7.33873 10.4086C7.01212 10.6634 6.95387 11.1347 7.20862 11.4613L8.39138 10.5387ZM10.95 16C10.95 16.4142 11.2858 16.75 11.7 16.75C12.1142 16.75 12.45 16.4142 12.45 16H10.95ZM12.45 5C12.45 4.58579 12.1142 4.25 11.7 4.25C11.2858 4.25 10.95 4.58579 10.95 5H12.45ZM4.125 15V16H5.625V15H4.125ZM4.125 16C4.125 18.0531 5.75257 19.75 7.8 19.75V18.25C6.61657 18.25 5.625 17.2607 5.625 16H4.125ZM7.8 19.75H15.6V18.25H7.8V19.75ZM15.6 19.75C17.6474 19.75 19.275 18.0531 19.275 16H17.775C17.775 17.2607 16.7834 18.25 15.6 18.25V19.75ZM19.275 16V15H17.775V16H19.275ZM12.2914 16.4613L16.1914 11.4613L15.0086 10.5387L11.1086 15.5387L12.2914 16.4613ZM12.2914 15.5387L8.39138 10.5387L7.20862 11.4613L11.1086 16.4613L12.2914 15.5387ZM12.45 16V5H10.95V16H12.45Z" fill="#ffffff"/>
                                    </svg>
                                    Export
                                </a>
                            </div>
                            
                            
                        </div>
                    
                        <!-- Filters Layout (Hidden by Default) -->
                        <div id="filters" class="card-body d-none mt-3">
                            <div class="row">
                                <!-- Status Filters -->
                                <div class="col-md-6">
                                    <div class="card" style="border-radius: 0;">
                                        <div class="card-header">
                                            Status Filters
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Include Section -->
                                                <div class="col-md-6">
                                                    <h7>Include</h7>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status[]" value="jawab oke" id="include_status_jawab_oke" {{ in_array('jawab oke', request('include_status', [])) ? 'checked' : '' }}>
                                                        <label for="include_status_jawab_oke" class="form-check-label">Jawab Oke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status[]" value="Lunas/paid" id="include_status_lunas_paid" {{ in_array('Lunas/ paid', request('include_status', [])) ? 'checked' : '' }}>
                                                        <label for="include_status_lunas_paid" class="form-check-label">Lunas/Paid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status[]" value="RNA" id="include_status_rna" {{ in_array('RNA', request('include_status', [])) ? 'checked' : '' }}>
                                                        <label for="include_status_rna" class="form-check-label">RNA</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status[]" value="Tidak aktif" id="include_status_tidak_aktif" {{ in_array('Tidak aktif', request('include_status', [])) ? 'checked' : '' }}>
                                                        <label for="include_status_tidak_aktif" class="form-check-label">Tidak Aktif</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status[]" value="Reject" id="include_status_reject" {{ in_array('Reject', request('include_status', [])) ? 'checked' : '' }}>
                                                        <label for="include_status_reject" class="form-check-label">Reject</label>
                                                    </div>
                                                </div>
                    
                                                <!-- Exclude Section -->
                                                <div class="col-md-6">
                                                    <h7>Exclude</h7>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status[]" value="jawab oke" id="exclude_status_jawab_oke" {{ in_array('jawab oke', request('exclude_status', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status_jawab_oke" class="form-check-label">Jawab Oke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status[]" value="Lunas/paid" id="exclude_status_lunas_paid" {{ in_array('Lunas/ paid', request('exclude_status', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status_lunas_paid" class="form-check-label">Lunas/Paid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status[]" value="RNA" id="exclude_status_rna" {{ in_array('RNA', request('exclude_status', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status_rna" class="form-check-label">RNA</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status[]" value="Tidak aktif" id="exclude_status_tidak_aktif" {{ in_array('Tidak aktif', request('exclude_status', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status_tidak_aktif" class="form-check-label">Tidak Aktif</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status[]" value="Reject" id="exclude_status_reject" {{ in_array('Reject', request('exclude_status', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status_reject" class="form-check-label">Reject</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Status 2 Filters -->
                                <div class="col-md-6">
                                    <div class="card" style="border-radius: 0;">
                                        <div class="card-header">
                                            Status 2 Filters
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Include Section -->
                                                <div class="col-md-6">
                                                    <h7>Include</h7>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status_2[]" value="jawab oke" id="include_status2_jawab_oke" {{ in_array('jawab oke', request('include_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="include_status2_jawab_oke" class="form-check-label">Jawab Oke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status_2[]" value="Lunas/paid" id="include_status2_lunas_paid" {{ in_array('Lunas/ paid', request('include_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="include_status2_lunas_paid" class="form-check-label">Lunas/Paid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status_2[]" value="RNA" id="include_status2_rna" {{ in_array('RNA', request('include_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="include_status2_rna" class="form-check-label">RNA</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status_2[]" value="Tidak aktif" id="include_status2_tidak_aktif" {{ in_array('Tidak aktif', request('include_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="include_status2_tidak_aktif" class="form-check-label">Tidak Aktif</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="include_status_2[]" value="Reject" id="include_status2_reject" {{ in_array('Reject', request('include_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="include_status2_reject" class="form-check-label">Reject</label>
                                                    </div>
                                                </div>
                    
                                                <!-- Exclude Section -->
                                                <div class="col-md-6">
                                                    <h7>Exclude</h7>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status_2[]" value="jawab oke" id="exclude_status2_jawab_oke" {{ in_array('jawab oke', request('exclude_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status2_jawab_oke" class="form-check-label">Jawab Oke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status_2[]" value="Lunas/paid" id="exclude_status2_lunas_paid" {{ in_array('Lunas/ paid', request('exclude_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status2_lunas_paid" class="form-check-label">Lunas/Paid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status_2[]" value="RNA" id="exclude_status2_rna" {{ in_array('RNA', request('exclude_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status2_rna" class="form-check-label">RNA</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status_2[]" value="Tidak aktif" id="exclude_status2_tidak_aktif" {{ in_array('Tidak aktif', request('exclude_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status2_tidak_aktif" class="form-check-label">Tidak Aktif</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="exclude_status_2[]" value="Reject" id="exclude_status2_reject" {{ in_array('Reject', request('exclude_status_2', [])) ? 'checked' : '' }}>
                                                        <label for="exclude_status2_reject" class="form-check-label">Reject</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Additional Filters -->
                                <!-- Add other filters as needed -->
                            </div>
                        </div>
                    </form>

                    

                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Snd</th>
                                <th>Nama Cli</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Status 2</th>
                                <th>Sheet Code</th>
                                @can('update user sheet')
                                <th>Act</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_sheet as $userSheet)
                                <tr>
                                    <td>{{ $userSheet->snd }}</td>
                                    <td>{{ $userSheet->nama_cli }}</td>
                                    <td>{{ $userSheet->no_hp }}</td>
                                    <td>{{ $userSheet->email }}</td>
                                    <td>{{ $userSheet->status }}</td>
                                    <td>{{ $userSheet->status_2 }}</td>
                                    <td>{{ $userSheet->sheet_code }}</td>
                                    @can('update user sheet')

                                    <td style="padding: 0;">
                                        <!-- Button Container -->
                                        <div class="btn-group" role="group" style="margin: 0; padding: 0; display: flex; gap: 0;">
                                            <!-- Show Link -->
                                            <button style="border: none; border-radius: 0px; background-color:#b1b1b0"class="btn btn-sm edit-snd" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSndModal" 
                                            data-snd="{{ $userSheet->snd }}" 
                                            data-sheet_code="{{ $userSheet->sheet_code }}">
                                            <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40974 4.40973 4.7157 4.21799 5.09202C4 5.51985 4 6.0799 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.0799 20 7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V12.5M15.5 5.5L18.3284 8.32843M10.7627 10.2373L17.411 3.58902C18.192 2.80797 19.4584 2.80797 20.2394 3.58902C21.0205 4.37007 21.0205 5.6364 20.2394 6.41745L13.3774 13.2794C12.6158 14.0411 12.235 14.4219 11.8012 14.7247C11.4162 14.9936 11.0009 15.2162 10.564 15.3882C10.0717 15.582 9.54378 15.6885 8.48793 15.9016L8 16L8.04745 15.6678C8.21536 14.4925 8.29932 13.9048 8.49029 13.3561C8.65975 12.8692 8.89125 12.4063 9.17906 11.9786C9.50341 11.4966 9.92319 11.0768 10.7627 10.2373Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            </button>
                                        </div>
                                    </td>
                                    @endcan
                                    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $user_sheet->appends(request()->query())->links() }}
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
                                <div class="mb-3">
                                    <label for="modal_nper" class="form-label">NPer</label>
                                    <input type="text" name="nper" id="modal_nper" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_snd" class="form-label">SND</label>
                                    <input type="text" name="snd" id="modal_snd" class="form-control" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_sheet_code" class="form-label">Sheet Code</label>
                                    <input type="text" name="sheet_code" id="modal_sheet_code" class="form-control" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="modal_snd_group" class="form-label">SND Group</label>
                                    <input type="text" name="snd_group" id="modal_snd_group" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_nama_cli" class="form-label">Nama CLI</label>
                                    <input type="text" name="nama_cli" id="modal_nama_cli" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_alamat" class="form-label">Alamat</label>
                                    <input type="text" name="alamat" id="modal_alamat" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modal_ubis" class="form-label">UBIS</label>
                                    <input type="text" name="ubis" id="modal_ubis" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_desc_newbill" class="form-label">Description New Bill</label>
                                    <input type="text" name="desc_newbill" id="modal_desc_newbill" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_usage_desc" class="form-label">Usage Description</label>
                                    <input type="text" name="usage_desc" id="modal_usage_desc" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_lama_berlangganan" class="form-label">Lama Berlangganan</label>
                                    <input type="text" name="lama_berlangganan" id="modal_lama_berlangganan" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_saldo" class="form-label">Saldo</label>
                                    <input type="text" name="saldo" id="modal_saldo" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_no_hp" class="form-label">No HP</label>
                                    <input type="text" name="no_hp" id="modal_no_hp" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="modal_email" class="form-label">Email</label>
                                    <input type="email" name="email" id="modal_email" class="form-control" readonly>
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
                        <select name="status" id="modal_status" class="form-control">
                            <option value="" disabled>Select a status</option>
                            <option value="JAWAB OKE" {{ old('status', $userSheet->status) == 'JAWAB OKE' ? 'selected' : '' }}>JAWAB OKE</option>
                            <option value="LUNAS/PAID" {{ old('status', $userSheet->status) == 'LUNAS/PAID' ? 'selected' : '' }}>LUNAS/PAID</option>
                            <option value="RNA" {{ old('status', $userSheet->status) == 'RNA' ? 'selected' : '' }}>RNA</option>
                            <option value="TIDAK AKTIF" {{ old('status', $userSheet->status) == 'TIDAK AKTIF' ? 'selected' : '' }}>TIDAK AKTIF</option>
                            <option value="REJECT" {{ old('status', $userSheet->status) == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                            <option value="KOMPLAIN" {{ old('status', $userSheet->status) == 'KOMPLAIN' ? 'selected' : '' }}>KOMPLAIN</option>

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
                        <select name="status_2" id="modal_status_2" class="form-control">
                            <option value="" disabled>Select a status</option>
                            <option value="JAWAB OKE" {{ old('status_2', $userSheet->status_2) == 'JAWAB OKE' ? 'selected' : '' }}>JAWAB OKE</option>
                            <option value="LUNAS/PAID" {{ old('status_2', $userSheet->status_2) == 'LUNAS/PAID' ? 'selected' : '' }}>LUNAS/PAID</option>
                            <option value="RNA" {{ old('status_2', $userSheet->status_2) == 'RNA' ? 'selected' : '' }}>RNA</option>
                            <option value="TIDAK AKTIF" {{ old('status_2', $userSheet->status_2) == 'TIDAK AKTIF' ? 'selected' : '' }}>TIDAK AKTIF</option>
                            <option value="REJECT" {{ old('status_2', $userSheet->status_2) == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                            <option value="KOMPLAIN" {{ old('status_2', $userSheet->status_2) == 'KOMPLAIN' ? 'selected' : '' }}>KOMPLAIN</option>

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9yquXh0W+MHjt/qJH6rY5w5U5Qd4f79B6sU8OCk9Ykkf6DPlAmz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-13f+G0dr4oX6xkjKgW9pCEesrdK2pfTiSiE9cA7VS3w6cS0xZZ2Q75ar7dAG5DBM" crossorigin="anonymous"></script>

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
                        editSndForm.action = `/user_sheet/${snd}/${sheetCode}`;

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

        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.querySelector('.toggle-text').classList.toggle('d-none', isExpanded);
                this.querySelector('.toggle-text.d-none').classList.toggle('d-none', !isExpanded);
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id'); // Extract info from data-* attributes
        var form = document.getElementById('updateForm');

        // Update the form action URL
        form.action = '/user_sheet/' + id;

        // Optionally, populate the form fields with data via AJAX
        // Example: Fetch data from the server and populate fields
    });
});
document.addEventListener('DOMContentLoaded', function () {
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var form = document.getElementById('updateForm');

        form.action = '/user_sheet/' + id;

        // Fetch existing data (example using fetch API)
        fetch('/user_sheet/' + id)
            .then(response => response.json())
            .then(data => {
                // Populate form fields with data
                document.querySelector('input[name="nper"]').value = data.nper;
                document.querySelector('input[name="snd"]').value = data.snd;
                // Repeat for other fields
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});

    </script>

    
<script>
    document.getElementById('reset-search').addEventListener('click', function() {
        const searchInput = document.querySelector('input[name="search"]');
        searchInput.value = ''; // Clear the input value
        document.getElementById('search-form').submit(); // Submit the form to reset the search
    });
    document.getElementById('show-filters-btn').addEventListener('click', function () {
    var filters = document.getElementById('filters');
    var button = this;
    if (filters.classList.contains('d-none')) {
        filters.classList.remove('d-none');
        button.textContent = 'Hide Filters';
    } else {
        filters.classList.add('d-none');
        button.textContent = 'Show Filters';
    }
});


</script>
    
@endsection
