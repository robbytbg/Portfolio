@extends('user_sheet.layouts')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<style>
    #pivotTable {
    border-collapse: collapse; /* Ensures borders do not overlap */
    width: 100%; /* Full width of the container */
    }

    #pivotTable th, #pivotTable td {
        border: 1px solid #ddd; /* Add border to cells */
        padding: 8px; /* Padding for cell content */
        text-align: left; /* Align text to the left */
    }

    #pivotTable thead th {
        background-color: grey; /* Grey background for table header */
        color: white; /* White text color for table header */
    }
    /* Styling for rows */
    .parent-row {
        font-weight: bold; /* Bold font for parent rows */
    }

    .branch-row {
        font-style: italic; /* Italic font for branch rows */
    }

    .expand-collapse-btn {
        cursor: pointer; /* Pointer cursor on hover */
        background: transparent; /* Transparent background */
        border: none; /* Remove border */
        padding: 0; /* Remove padding */
        font-size: 1rem; /* Adjust font size */
        color: #000; /* Text color */
        font-weight: bold;
        outline: none; /* Remove outline */
    }

    .expand-collapse-btn span {
        display: inline-block; /* Inline block for span styling */
        font-size: 1rem; /* Font size */
    }

    .expand-collapse-btn:hover {
        color: #007bff; /* Change color on hover */
    }

    /* Ensure content fits within table cells */
    .summary-info {
        display: flex; /* Use flexbox for alignment */
        flex-direction: column; /* Stack items vertically */
        justify-content: center; /* Center items vertically */
        align-items: flex-start; /* Align items to the start of the cell */
        width: 100%; /* Ensure it takes the full width of the cell */
        box-sizing: border-box; /* Include padding and border in element's total width and height */
        overflow: hidden; /* Hide any overflowing content */
    }

    .summary-info .total,
    .summary-info .snd-count {
        margin: 0; /* Remove margin */
        white-space: nowrap; /* Prevent text from wrapping */
        overflow: hidden; /* Ensure content does not overflow */
        text-overflow: ellipsis; /* Add ellipsis for overflowing text */
    }

</style>

<div class="container" style="padding: 0.8rem; height: 100vh; margin-top:-1rem">

    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 1rem; display: flex; width: 100%;">
        <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link" id="customer-info-tab" data-bs-toggle="tab" data-bs-target="#customer-info" type="button" role="tab" aria-controls="customer-info" aria-selected="true" style="width: 100%;">Caring dashboard</button>
        </li>
        <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link" id="editing-tab" data-bs-toggle="tab" data-bs-target="#editing" type="button" role="tab" aria-controls="editing" aria-selected="false" style="width: 100%;">Business report</button>
        </li>
    </ul>
    

    <div class="tab-content mt-3" >
        
        <div class="tab-pane fade show active" id="customer-info" role="tabpanel" aria-labelledby="customer-info-tab"  style="margin-top: -1rem;">
            <div class="card">


                <div class="card-body">

            <!-- First Row -->
                <div class="row mb-4" style="height: 40%; display: flex; overflow: hidden;">
                    <!-- First Column: Pie Chart (40%) -->
                    <div class="col-md-5" style="flex: 1 1 40%; display: flex; min-width: 0; max-height: 100%;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column; max-height: 100%;">
                
                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center; max-height: 100%;">
                                <canvas id="categoryChart" style="width: auto; height: 100%; max-height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                
                    <!-- Second Column: Bar Chart (Petugas) (40%) -->
                    <div class="col-md-5" style="flex: 1 1 40%; display: flex; min-width: 0; max-height: 100%;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column; max-height: 100%;">
                
                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center; max-height: 100%;">
                                <canvas id="petugasChart" style="width: 100%; height: auto; max-height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                
                    <!-- Third Column: Statistics and Dropdown (20%) -->
                    <div class="col-md-2" style="flex: 1 1 20%; display: flex; flex-direction: column; max-height: 100%;">
                        <!-- Statistics Card -->
                        <div class="card mb-4" style="flex: 1; max-height: 70%;">
                            <div class="card-body" style="margin: 5px; padding: 10px; border: solid #b1b0b1 1px; border-radius: 5%; max-height: 100%;">
                                <h7>Total Saldo Customer (Rp.)</h7>
                                <h6>{{ number_format($totalSaldo, 0, ',', ',') }}</h6>
                                <h7>Total Customer</h7>
                                <h6>{{ $totalCustomer }}</h6>
                            </div>
                        </div>
                
                        <!-- Year and Month Dropdown -->
                        <div class="card mb-4" style="flex: 1; max-height: 30%;padding-top:-1rem">
                            <div class="card-body" style="flex: 1;max-height: 100%;">
                                <form method="GET" action="{{ route('user_sheet.dashboard') }}">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="yearFilter">Year:</label>
                                            <select id="yearFilter" name="year" class="form-control" onchange="this.form.submit()" style="font-size: 0.75rem;">
                                                <option value="">All</option>
                                                @php
                                                $startYear = 2023; // Ensure the start year is at least 2021
                                                $endYear = date('Y'); // The current year
                                                @endphp
                
                                                @foreach(range($startYear, $endYear) as $year)
                                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="monthFilter">Month:</label>
                                            <select id="monthFilter" name="month" class="form-control" onchange="this.form.submit()" style="font-size: 0.75rem;">
                                                <option value="">All</option>
                                                @foreach(range(1, 12) as $month)
                                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="display: flex; align-items: center; justify-content: center;">
                                            <a href="{{ route('user_sheet.dashboard') }}" class="btn btn-secondary btn-sm" style="
                                                transform: rotate(-90deg);
                                                transform-origin: left bottom;
                                                display: inline-block;
                                                margin-left: 100px;
                                                margin-top: 20px;
                                            ">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Second Row -->
                <div class="row" style="height: 40%; display: flex;">
                    <!-- First Column: Line Chart (50%) -->
                    <div class="col-md-6" style="display: flex;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column; max-height: 100%;">

                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center;max-height: 100%;">
                                <canvas id="dateCustomerChart" style="width: 100%; height: auto;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Second Column: Bar Chart (Status) (50%) -->
                    <div class="col-md-6" style="display: flex;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column;max-height: 100%;">

                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center;max-height: 100%;">
                                <canvas id="statusChart" style="width: 100%; height: auto;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="editing" role="tabpanel" aria-labelledby="editing-tab" style="margin-top: -1rem">
                <div class="card">
                    <div class="card-body">
                <!-- Main Container for Table and Chart -->
                <div class="row mb-4" style="max-height: 45vh; display: flex; overflow: hidden;">
                    
                    <!-- Table Section -->
                    <div class="col-md-6" style="display: flex; max-height: 100%; overflow: auto;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column; height: 100%; overflow: hidden;">
                            <div class="card-body" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                                <h6 class="text-center">Matrix of detailed report</h6>
                                <div style="overflow-y: auto; max-height: 40vh; flex: 1;">
                                    <table border="1" id="pivotTable" style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;"></th>
                                                <th style="width: 15%; font-size: 1vw;">Status Paid</th>
                                                <th style="width: 15%; font-size: 1vw;">Branch</th>
                                                <th style="width: 15%; font-size: 1vw;">STO</th>
                                                <th style="width: 25%; font-size: 1vw;">Total</th>
                                                <th style="width: 15%; font-size: 0.75vw;">Percentage (%)</th>
                                                <th style="width: 10%; font-size: 0.75vw;">SND Count</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $grandTotal = 0;
                                                $grandSndCount = 0;
                                            @endphp
                                            @foreach ($sunburstData as $statusPaid => $branches)
                                                @php
                                                    $branchesCollection = collect($branches);
                                                    $totalForStatus = $branchesCollection->sum(function ($branchData) {
                                                        return collect($branchData)->sum('total');
                                                    });
                                                    $sndCountForStatus = $branchesCollection->sum(function ($branchData) {
                                                        return collect($branchData)->sum('count');
                                                    });
                                                    $grandTotal += $totalForStatus;
                                                    $grandSndCount += $sndCountForStatus;
                                                @endphp
                                            @endforeach
                    
                                            @foreach ($sunburstData as $statusPaid => $branches)
                                                @php
                                                    $branchesCollection = collect($branches);
                                                    $totalForStatus = $branchesCollection->sum(function ($branchData) {
                                                        return collect($branchData)->sum('total');
                                                    });
                                                    $sndCountForStatus = $branchesCollection->sum(function ($branchData) {
                                                        return collect($branchData)->sum('count');
                                                    });
                                                    $percentageForStatus = ($grandTotal > 0) ? ($totalForStatus / $grandTotal) * 100 : 0;
                                                @endphp
                                                <tr class="parent-row green-row" data-status="{{ $statusPaid }}">
                                                    <td>
                                                        <button class="expand-collapse-btn" data-target=".branch-row[data-status='{{ $statusPaid }}']"><span>+</span></button>
                                                    </td>
                                                    <td style="font-size: 0.95vw;">{{ $statusPaid }}</td>
                                                    <td colspan="3">
                                                        <div class="summary-info" style="font-size: 0.95vw;">
                                                            <div class="total">Rp{{ number_format($totalForStatus, 0, ',', '.') }}</div>
                                                        </div>
                                                    </td>
                                                    <td style="font-size: 0.95vw; text-align: right;">{{ number_format($percentageForStatus, 2) }}%</td>
                                                    <td style="font-size: 0.95vw;">{{ $sndCountForStatus }}</td>
                                                </tr>
                                                @foreach ($branches as $branch => $stos)
                                                    @php
                                                        $stosCollection = collect($stos);
                                                        $totalForBranch = $stosCollection->sum('total');
                                                        $sndCountForBranch = $stosCollection->sum('count');
                                                        $percentageForBranch = ($grandTotal > 0) ? ($totalForBranch / $grandTotal) * 100 : 0;
                                                    @endphp
                                                    <tr class="branch-row branch-green-row" data-status="{{ $statusPaid }}" data-branch="{{ $branch }}" style="display: none;">
                                                        <td></td>
                                                        <td>
                                                            <button class="expand-collapse-btn" data-target=".grandchild-row[data-status='{{ $statusPaid }}'][data-branch='{{ $branch }}']"><span>+</span></button>
                                                        </td>
                                                        <td style="font-size: 80%;">{{ $branch }}</td>
                                                        <td colspan="2">
                                                            <div class="summary-info" style="font-size: 90%;">
                                                                <div class="total">Rp{{ number_format($totalForBranch, 0, ',', '.') }}</div>
                                                            </div>
                                                        </td>
                                                        <td style="font-size: 80%; text-align: right;">{{ number_format($percentageForBranch, 2) }}%</td>
                                                        <td style="font-size: 80%;">{{ $sndCountForBranch }}</td>
                                                    </tr>
                                                    @foreach ($stos as $sto => $data)
                                                        @php
                                                            $percentageForSto = ($grandTotal > 0) ? ($data['total'] / $grandTotal) * 100 : 0;
                                                        @endphp
                                                        <tr class="grandchild-row" data-status="{{ $statusPaid }}" data-branch="{{ $branch }}" data-sto="{{ $sto }}" style="display: none; font-size: 90%;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $sto }}</td>
                                                            <td>Rp{{ number_format($data['total'], 0, ',', '.') }}</td>
                                                            <td>{{ number_format($percentageForSto, 2) }}%</td>
                                                            <td>{{ $data['count'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            <tr class="grand-total-row">
                                                <td colspan="4" style="text-align: right; font-size: 80%; font-weight: bold;">Grand Total</td>
                                                <td style="font-size: 80%; font-weight: bold;">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                                                <td style="font-size: 80%; font-weight: bold; text-align: right;">100%</td>
                                                <td style="font-size: 80%; font-weight: bold;">{{ $grandSndCount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Chart Section -->
                    <div class="col-md-6" style="display: flex;">
                        
                        <div class="card flex-fill" style="display: flex; flex-direction: column; overflow: hidden;">
                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center;max-width: 100%; max-height">
                                <div id="myDiv" style="flex: 1; max-width: auto; max-height: 40vh; display: flex; align-items: center; justify-content: center;"></div>
                            
                            </div>
                        </div>
                        <div class="col-md-1" style="display: flex; align-items: center; justify-content: center;">
                            <a href="{{ route('user_sheet.dashboard') }}" class="btn btn-secondary btn-sm" style="
                                transform: rotate(-90deg);
                                transform-origin: left bottom;
                                display: inline-block;
                                margin-left: 30px;
                                margin-top: 20px;
                            ">Reset</a>
                        </div>
                    </div>
                    
                </div>
            
                <!-- Additional Chart Section (Combo Chart) -->
                <div class="row mb-4" style="max-height: 38vh; display: flex; overflow: hidden;">
                    <div class="col-md-12" style="display: flex; height: 100%; justify-content: center; align-items: center; padding: 0;">
                        <div class="card flex-fill" style="display: flex; flex-direction: column; height: 100%; width: 100%; margin-right:10px; margin-left:13px">
                            <div class="card-body" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0; width: 100%;">
                                <div id="combo-chart" style="max-width:80vw;max-height: 35vh; margin: 0; padding: 0;margin-bottom:10px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </div>
    <div>
</div>



<!-- Include Chart.js and Chart.js Data Labels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<script>
    // Open Overlay
    document.getElementById('openOverlay').addEventListener('click', function() {
      document.getElementById('overlay').style.display = 'block';
    });
  
    // Close Overlay
    document.getElementById('closeOverlay').addEventListener('click', function() {
      document.getElementById('overlay').style.display = 'none';
    });
  </script>

<script>
    Chart.register(ChartDataLabels); // Register the plugin globally

    document.addEventListener('DOMContentLoaded', function () {
    // Get current filter values
        var currentFilters = {
            year: '{{ request('year') }}',
            month: '{{ request('month') }}',
            petugas: '{{ request('petugas') }}',
            sheet_code: '{{ request('sheet_code') }}',
            status: '{{ request('status') }}',
            date: '{{ request('date') }}',
            status_paid: '{{ request('status_paid') }}', // Added status_paid filter
            branch: '{{ request('branch') }}' // Added branch filter
        };

        // Helper function to build URL with filters
        function buildUrl(filters) {
            var queryString = new URLSearchParams(filters).toString();
            return `{{ route('user_sheet.dashboard') }}?${queryString}`;
        }

        // Category Chart (Pie)
        var labelsCategory = @json($categoryData->pluck('sheet_code'));
        var dataCategory = @json($categoryData->pluck('count'));

        var baseColors = ['#a1c6ea', '#b2e4b1', '#b2e0e0', '#f2e29b', '#c6c8d0'];
        var extendedColors = [];

        // Extend baseColors to match the number of data points
        for (var i = 0; i < dataCategory.length; i++) {
            extendedColors.push(baseColors[i % baseColors.length]);
        }


        var ctxCategory = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(ctxCategory, {
            type: 'pie',
            data: {
                labels: labelsCategory,
                datasets: [{
                    data: dataCategory,
                    backgroundColor: extendedColors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'SheetCode Distribution'  // Set the title text
                    },
                    datalabels: {
                        color: '#000',
                        
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                            const percentage = (value / total * 100).toFixed(2);
                            return `${value} (${percentage}%)`;
                        },
                        anchor: 'end',
                        align: 'start',
                        font: {
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom', // Set the legend position to the bottom

                        labels: {
                            color: '#000',
                            boxWidth: 10,
                            padding: 10
                        },
                        onClick: function (event, legendItem) {
                            // Use the legendItem to get the index
                            var index = legendItem.index;
                            handleExclusion(index);
                        }
                    }
                }
            }
        });

        // Initialize the Set to store excluded categories
        var excludedCategories = new Set();

        // Function to handle category exclusion
        function handleExclusion(index) {
            var excludedCategory = labelsCategory[index];
            
            // Exclude the category from the chart
            labelsCategory.splice(index, 1);
            dataCategory.splice(index, 1);
            extendedColors.splice(index, 1);

            // Update the chart with the remaining categories
            categoryChart.update();

            // Add the new category to the excluded list
            excludedCategories.add(excludedCategory);

            // Retrieve existing exclusions from the current URL or session
            var existingExcluded = new URLSearchParams(window.location.search).get('ex_sheet_code');
            if (existingExcluded) {
                existingExcluded = decodeURIComponent(existingExcluded);
                existingExcluded.split(',').forEach(cat => excludedCategories.add(cat));
            }

            // Encode the updated list of excluded categories
            var encodedCategories = encodeURIComponent(Array.from(excludedCategories).join(','));

            // Redirect with the updated categories filter
            window.location.href = buildUrl({ ...currentFilters, ex_sheet_code: encodedCategories });
        }


        // Add click event listener to the chart's canvas for pie segments
        categoryChart.canvas.addEventListener('click', function (event) {
            var activePoints = categoryChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
            if (activePoints.length > 0) {
                var index = activePoints[0].index;
                var selectedCategory = labelsCategory[index];
                
                // Perform the drill-down by redirecting with the selected category filter
                window.location.href = buildUrl({ ...currentFilters, sheet_code: selectedCategory });
            }
        });


        // Get labels and data from server-side
        var labelsStatus = @json($customerStatus->pluck('status'));
        var dataStatus = @json($customerStatus->pluck('count'));

        // Filter out null or empty labels
        var filteredData = labelsStatus
            .map((label, index) => ({ label, data: dataStatus[index] }))
            .filter(item => item.label && item.label.trim() !== '');

        // Separate the filtered data into labels and data arrays
        var filteredLabels = filteredData.map(item => item.label);
        var filteredDataValues = filteredData.map(item => item.data);

        // Create the chart
        var ctxStatus = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: filteredLabels,
                datasets: [{
                    label: 'Customer Count',
                    data: filteredDataValues,
                    backgroundColor: '#EE99C2'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Customers Status'  // Set the title text
                    },
                    datalabels: {
                        color: '#000',
                        anchor: 'center',
                        align: 'center',
                        font: {
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false,
                        labels: {
                            color: 'rgba(0,0,0,0)',
                            boxWidth: 10,
                            padding: 10,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Add click event listener to the bar chart
        statusChart.canvas.addEventListener('click', function (event) {
            var activePoints = statusChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
            if (activePoints.length > 0) {
                var index = activePoints[0].index;
                var selectedStatus = filteredLabels[index];
                window.location.href = buildUrl({ ...currentFilters, status: selectedStatus });
            }
        });


        // Get labels and data from server-side
        var labelsPetugas = @json($customerByPetugas->pluck('petugas'));
        var dataPetugas = @json($customerByPetugas->pluck('count'));

        // Filter out null or empty labels
        var filteredPetugasData = labelsPetugas
            .map((label, index) => ({ label, data: dataPetugas[index] }))
            .filter(item => item.label && item.label.trim() !== '');

        // Separate the filtered data into labels and data arrays
        var filteredPetugasLabels = filteredPetugasData.map(item => item.label);
        var filteredPetugasDataValues = filteredPetugasData.map(item => item.data);

        // Create the chart
        var ctxPetugas = document.getElementById('petugasChart').getContext('2d');
        var petugasChart = new Chart(ctxPetugas, {
            type: 'bar',
            data: {
                labels: filteredPetugasLabels,
                datasets: [{
                    label: 'Customer Count',
                    data: filteredPetugasDataValues,
                    backgroundColor: '#EE99C2'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Customer per Caring in-charge'  // Set the title text
                    },
                    datalabels: {
                        color: '#000',
                        anchor: 'center',
                        align: 'center',
                        font: {
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // Handle clicks on the chart
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        var index = elements[0].index;
                        var petugas = this.data.labels[index];
                        window.location.href = buildUrl({ ...currentFilters, petugas: petugas });
                    }
                }
            }
        });

        // Get labels and data from server-side
        var labelsDate = @json($dateCustomerCount->pluck('date'));
        var dataDate = @json($dateCustomerCount->pluck('count'));

        // Helper function to check if a date is valid
        function isValidDate(dateString) {
            var date = new Date(dateString);
            return !isNaN(date.getTime()) && dateString.trim() !== '';
        }

        // Function to handle date normalization and validation
        function normalizeAndFilterDates(labels, data) {
            return labels.map((date, index) => ({
                date: date.trim(),  // Trim any extra whitespace
                count: data[index]
            }))
            .filter(item => {
                var date = new Date(item.date);
                return !isNaN(date.getTime()) && item.date !== ''; // Ensure valid date
            });
        }

        // Normalize and filter dates
        var combined = normalizeAndFilterDates(labelsDate, dataDate);

        // Sort combined array by date
        combined.sort((a, b) => new Date(a.date) - new Date(b.date));

        // Extract sorted data
        var sortedLabels = combined.map(item => item.date);
        var sortedData = combined.map(item => item.count);

        var ctxDateCustomer = document.getElementById('dateCustomerChart').getContext('2d');
        var dateCustomerChart = new Chart(ctxDateCustomer, {
            type: 'line',
            data: {
                labels: sortedLabels,
                datasets: [{
                    label: 'Customer Caring Intensity',
                    data: sortedData,
                    borderColor: '#EE99C2',
                    backgroundColor: 'rgba(238, 153, 194, 0.5)', // Set a semi-transparent background color
                    fill: true // Enable filling the area under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Caring Intensity'  // Set the title text
                    },
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'center',
                        font: {
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: false,
                        labels: {
                            color: '#000'
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Add click event listener to the line chart
        dateCustomerChart.canvas.addEventListener('click', function (event) {
            var activePoints = dateCustomerChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
            if (activePoints.length > 0) {
                var index = activePoints[0].index;
                var selectedDate = sortedLabels[index];
                window.location.href = buildUrl({ ...currentFilters, date: selectedDate });
            }
        });


        // Sunburst Chart
        var rawData = @json($sunburstData); // Pass raw data from the controller

        // Initialize arrays
        var ids = [];
        var labels = [];
        var parents = [];
        var values = []; // To store the `total` values
        var colors = []; // To store colors for each node
        var isBranch = false;
        var isStart = true; // Assume start state initially

        // Helper function to format numbers with commas
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getUrlParameter(name) {
            // Escape special characters for the regex pattern
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            
            // Regular expression to match the parameter and capture its value
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            
            // Debugging output
            console.log('Regex Results for', name, ':', results);
            
            // Decode the captured value and replace '+' with space, then return it
            var paramValue = results ? decodeURIComponent(results[1].replace(/\+/g, ' ')) : '';
            
            // Debugging output
            console.log('Parameter Value for', name, ':', paramValue);
            
            return paramValue;
            }

            // Get URL parameters
            var branchParam = getUrlParameter('branch').trim(); // Trim to handle any extra spaces
            var statPaid = getUrlParameter('status_paid').trim(); // Trim to handle any extra spaces


            // Debugging output
            console.log('Branch Param:', branchParam);
            console.log('Status Paid:', statPaid);

            if (statPaid !== '') {
                isStart = false; // statPaid is not empty
            }
            console.log('stat Results for', isStart);


            if (branchParam !== '') {
                isBranch = true; // branch is present
            }
            console.log('brancg Results for', isBranch);

            // Color scheme for each level
            var sunburstcolorway = ['#E7CCCC', '#EDE8DC', '#A5B68D', '#C1CFA1'];
            var colorStart = ['lightcoral', 'skyblue', '', '']


            var rows = document.querySelectorAll('.branch-row');
            // Loop through each row and assign a background color from the array
            rows.forEach(function(row) {
                var branch = row.getAttribute('data-branch'); // Get the branch name from the data attribute
                var color;

                // Determine the color based on the branch name
                if (branch === "JAMBI") {
                    color = sunburstcolorway[0];
                } else if (branch === "MUARABUNGO") {
                    color = sunburstcolorway[1];
                } else if (branch === "SUNGAI PENUH") {
                    color = sunburstcolorway[2];
                } else if (branch === "MUARO JAMBI") {
                    color = sunburstcolorway[3];
                } else {
                    color = "skyblue";
                }

                // Apply the color to the row
                row.style.backgroundColor = color;
            });

        // Get all branch rows in the pivot table
        var rows = document.querySelectorAll('.parent-row');

        // Loop through each row and assign a background color from the array
        rows.forEach(function(row,) {
            // Calculate the color based on the index
            var status = row.getAttribute('data-status'); // Get the branch name from the data attribute
            var color;
            if (status === "UNPAID") {
                color = colorStart[0];
            } else if (status === "PAID") {
                color = colorStart[1];
            }
            // Apply the color to the row, preserving other inline styles
            row.style.backgroundColor = color;
        });

        // Process the raw data to create the sunburst model
        function addNode(id, parent, label, value, isRoot, color, colorInd) {
            ids.push(id);
            parents.push(parent);

            // Determine the color for the node
            let nodeColor;
            let labelText;

            if (isStart) {
                // Use colorStart for nodes when isStart is true
                if(label.toUpperCase() === "UNPAID" ){
                        nodeColor = colorStart[0]
                }
                else if(label.toUpperCase() === "PAID" ){
                    nodeColor = colorStart[1]

                }                // Push the label with formatting
                labelText = `${label}<br>(${formatNumber(value)}, ${(value / totalSum * 100).toFixed(2)}%)`;
            } 

            else {

                if (isBranch && isRoot) {
                    labelText = `${label}`; // No additional formatting
                    if(statPaid.toUpperCase() === "UNPAID" ){
                        nodeColor = colorStart[0]
                    }
                    else if(statPaid.toUpperCase() === "PAID" ){
                        nodeColor = colorStart[1]

                    }
                    
                } 
                else if(isBranch && !isRoot){
                    labelText = `${label}<br>(${formatNumber(value)}, ${(value / totalSum * 100).toFixed(2)}%)`;

                    if(branchParam.toUpperCase() === "JAMBI"){
                        nodeColor = sunburstcolorway[0]
                    }
                    else if(branchParam.toUpperCase() === "MUARABUNGO"){
                        nodeColor = sunburstcolorway[1]
                    }
                    else if(branchParam.toUpperCase() === "SUNGAI PENUH"){
                        nodeColor = sunburstcolorway[2]
                    }
                    else if(branchParam.toUpperCase() === "MUARO JAMBI"){
                        nodeColor = sunburstcolorway[3]
                    }
                    else{
                        nodeColor = "grey"
                    }
                }
                else{
                    labelText = `${label}<br>(${formatNumber(value)}, ${(value / totalSum * 100).toFixed(2)}%)`;
                    
                }
                

        }
            

            // Add the color to the colors array
            colors.push(nodeColor);
            // Add the formatted label
            labels.push(labelText);
            // Add the value
            values.push(value);
        }


        var totalSum = 0;
        var statusPaidTotals = {};

        // First, calculate the totals for each `statusPaid` and overall total
        for (var statusPaid in rawData) {
            if (rawData.hasOwnProperty(statusPaid)) {
                var statusPaidTotal = 0;
                var branches = rawData[statusPaid];

                for (var branch in branches) {
                    if (branches.hasOwnProperty(branch)) {
                        var branchTotal = 0;
                        var stos = branches[branch];

                        for (var sto in stos) {
                            if (stos.hasOwnProperty(sto)) {
                                var stoTotal = stos[sto]['total'];
                                branchTotal += stoTotal;
                            }
                        }
                        statusPaidTotal += branchTotal;
                    }
                }
                statusPaidTotals[statusPaid] = statusPaidTotal;
                totalSum += statusPaidTotal;
            }
        }

        // Calculate and assign values
    // Calculate and assign values
     var colorIndex = 0;
        for (var statusPaid in rawData) {
            if (rawData.hasOwnProperty(statusPaid)) {
                var branches = rawData[statusPaid];
                var statusPaidTotal = statusPaidTotals[statusPaid];
                var statusPaidValue = totalSum * (statusPaidTotal / totalSum); // Corrected calculation

                // Add the statusPaid node with proportionate value
                addNode(statusPaid, '', statusPaid, statusPaidValue, true, sunburstcolorway[colorIndex], colorIndex);

                for (var branch in branches) {
                    if (branches.hasOwnProperty(branch)) {
                        var branchTotal = 0;
                        var branchId = statusPaid + " - " + branch;
                        var stos = branches[branch];

                        for (var sto in stos) {
                            if (stos.hasOwnProperty(sto)) {
                                var stoTotal = stos[sto]['total'];
                                branchTotal += stoTotal;
                            }
                        }

                        // The branch value is proportionate to its total within the statusPaidValue
                        var branchValue = (branchTotal / statusPaidTotal) * statusPaidValue;
                        addNode(branchId, statusPaid, branch, branchValue, false, sunburstcolorway[(colorIndex + 1) % sunburstcolorway.length, colorIndex + 1]);

                        // Add STOs under each branch
                        for (var sto in stos) {
                            if (stos.hasOwnProperty(sto)) {
                                var stoTotal = stos[sto]['total'];
                                var stoId = branchId + " - " + sto;

                                // The STO value is proportionate to its branch's total
                                var stoValue = (stoTotal / branchTotal) * branchValue;
                                addNode(stoId, branchId, sto, stoValue, false, sunburstcolorway[(colorIndex + 2) % sunburstcolorway.length, colorIndex + 2]);
                            }
                        }
                    }
                }
                colorIndex++;
            }
        }

        // Create the Plotly sunburst chart
        var data = [{
            type: "sunburst",
            ids: ids,
            labels: labels,
            parents: parents,
            values: values,
            branchvalues: "total",
            insidetextorientation: "horizontal", // Keep text horizontal
            outsidetextfont: { size: 16, color: "#000000" }, // Adjust font size and color
            marker: {
                line: { width: 2 },
                colors: colors // Apply the colors array to the nodes
            },
        }];

        var layout = {
            title: {
                text: "Status and Total of Payment",  // Set the title text
                font: {
                    size: 14,                  // Adjust the font size
                    color: "#000000"            // Set the title color
                },
                x: 0.5,                        // Center the title horizontally
                xanchor: 'center',             // Anchor the title to the center
            },
            margin: { l: 0, r: 0, b: 0, t: 30 },  // Adjust top margin for title space
            sunburstcolorway: sunburstcolorway,
            font: {
                size: 14,                      // Keep the general font size for the chart
                color: "#000000"
            },
            autosize: true,                     // Ensure the chart resizes appropriately
        };


        Plotly.newPlot('myDiv', data, layout);

        // Add click event listener to the sunburst chart
        document.getElementById('myDiv').on('plotly_click', function (eventData) {
            var point = eventData.points[0];
            var selectedId = point.id;
            var selectedParent = point.parent;

            // Extract clean IDs for URL parameters
            var cleanSelectedId = extractCleanId(selectedId);
            var cleanSelectedParent = extractCleanId(selectedParent);

            // Redirect with current filters applied
            if (selectedParent === '') { // Root node (status_paid)
                if (cleanSelectedId === currentFilters.status_paid && !currentFilters.branch) {
                    // If clicked on the same `status_paid` and no branch is selected, go back to the dashboard
                    window.location.href = buildUrl({ ...currentFilters, status_paid: cleanSelectedId });
                } else {
                    // Otherwise, drill down to the `status_paid`
                    window.location.href = buildUrl({ ...currentFilters, status_paid: cleanSelectedId });
                }
            } else if (selectedId.includes(' - ') && !selectedId.includes(' - ', selectedId.indexOf(' - ') + 1)) { // Branch
                var branch = cleanSelectedId.split(' - ')[1]; // Extract clean branch name
                window.location.href = buildUrl({ ...currentFilters, status_paid: cleanSelectedParent, branch: branch });
            }
        });

        // Helper function to extract clean ID from formatted label
        function extractCleanId(id) {
            return id.split('<')[0].trim(); // Remove any HTML and trim spaces
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listener to buttons
        document.querySelectorAll('.expand-collapse-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetSelector = this.getAttribute('data-target');
                const targetRows = document.querySelectorAll(targetSelector);
                const isExpanded = this.textContent.trim() === '-'; // Check for expanded state
                
                targetRows.forEach(function(row) {
                    row.style.display = isExpanded ? 'none' : 'table-row';
                });

                // Toggle button text
                this.textContent = isExpanded ? '+' : '-';
            });
        });
    });
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data passed from Laravel
        var barChartData = @json($barChartData);
        var percentageGrowth = @json($percentageGrowth);

        // Function to filter out data with empty dates
        function filterData(data) {
            return data.filter(item => item.date && item.date.trim() !== '');
        }

        // Filter out empty dates from percentageGrowth data
        var filteredGrowthData = filterData(percentageGrowth);

        // Prepare bar chart traces
        var barTraces = [];
        var sunburstcolorway = ['#E7CCCC', '#EDE8DC', '#A5B68D', '#C1CFA1'];

        for (const [index, branch] of Object.keys(barChartData).entries()) {
            const branchData = barChartData[branch];

            // Filter out empty dates from branch data
            var filteredBranchDates = branchData.dates.filter((date, i) => date && date.trim() !== '');
            var filteredBranchTotag = branchData.totag.filter((_, i) => branchData.dates[i] && branchData.dates[i].trim() !== '');

            // Determine color based on branch name
            let color;
            if (branch === "JAMBI") {
                color = sunburstcolorway[0];
            } else if (branch === "MUARABUNGO") {
                color = sunburstcolorway[1];
            } else if (branch === "SUNGAI PENUH") {
                color = sunburstcolorway[2];
            } else if (branch === "MUARO JAMBI") {
                color = sunburstcolorway[3];
            } else {
                color = "skyblue"; // Default color if branch name doesn't match
            }

            barTraces.push({
                x: filteredBranchDates,
                y: filteredBranchTotag,
                name: `Branch ${branch}`,
                type: 'bar',
                textposition: 'outside',
                hovertemplate: 'Totag: %{y:,}', // Format hover text with commas
                textfont: {
                    family: 'Arial',
                    size: 14,
                    color: '#000',
                },
                marker: {
                    color: color // Assign the calculated color
                },
            });
        }

        // Filter out empty dates from the percentage growth trace
        var growthTrace = {
            x: filteredGrowthData.map(g => g.date),
            y: filteredGrowthData.map(g => g.growth),
            name: 'Percentage Growth',
            type: 'scatter',
            mode: 'lines+markers+text',
            yaxis: 'y2',
            line: {     
                color: '#FFC96F', // Set the line color to grey    
                dash: 'slid' // Use 'dash' for a dashed line style
            },
            marker: {
                color: '#FFC96F', // Set the marker color to maroon
            },
            text: filteredGrowthData.map(g => g.growth !== null ? `${g.growth.toFixed(2)}%` : ''),
            textposition: 'inside',

            textfont: {    
                family: 'Helvetica',    
                size: 14,    
                color: '#000',
                weight:700
            },

            textangle: -45, // Tilt text labels at a 45-degree angle
            hovertemplate: 'Growth: %{y:.2f}%', 
            y: filteredGrowthData.map(g => g.growth + 1.0), // Small manual adjustment
        };

        // Plot the combo chart
        var layout = {
            xaxis: { 
                title: 'Payment Date',
            },
            yaxis: { 
                title: 'Totag',
                tickformat: ',.2f', // Comma separator for large numbers without "M"
                automargin: true, // Auto-adjust margins to avoid overflow
            },
            yaxis2: {
                overlaying: 'y',
                side: 'right',
                tickformat: ',.2f%',
                showline: false,
                showticklabels: false,
                automargin: true
            },
            barmode: 'group',
            showlegend: false,
            legend: {
                x: 1, // Position legend at the right
                y: 1.1, // Position legend at the top
                xanchor: 'right', // Anchor the legend by the right side
                yanchor: 'top', // Anchor the legend by the top
                orientation: 'h', // Vertical orientation
            },
            title: {
                text: "Day by day Growth of Totag",  // Set the title text
                font: {
                    size: 14,                  // Adjust the font size
                    color: "#000000"            // Set the title color
                },
                x: 0.5,                        // Center the title horizontally
                xanchor: 'center',             // Anchor the title to the center
            },
            margin: {
                l: 0, // Increase left margin
                r: 0, // Increase right margin
                b: 50, // Increase bottom margin to avoid x-axis label cutoff
                t: 50, // Increase top margin for title
            },

            plot_bgcolor: 'transparent',
            paper_bgcolor: 'transparent',
        };

        Plotly.newPlot('combo-chart', [...barTraces, growthTrace], layout);
    });
</script>

<script>
    // Function to set the active tab and its content
    function setActiveTab(tabId) {
        // Remove 'show' and 'active' classes from all tab-panes
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });

        // Activate the selected tab
        const tab = document.querySelector(`#${tabId}`);
        const tabContent = document.querySelector(tab.getAttribute('data-bs-target'));

        if (tab && tabContent) {
            // Initialize Bootstrap Tab component
            const tabInstance = new bootstrap.Tab(tab);

            // Activate the tab
            tabInstance.show();

            // Ensure content is shown
            tabContent.classList.add('show', 'active');
        }
    }

    // Store active tab in localStorage on tab click
    document.querySelectorAll('.nav-link').forEach(button => {
        button.addEventListener('click', function() {
            const activeTabId = this.id;
            localStorage.setItem('activeTab', activeTabId);
        });
    });

    // Set active tab and content on page load
    document.addEventListener('DOMContentLoaded', () => {
        const activeTabId = localStorage.getItem('activeTab');
        if (activeTabId) {
            setActiveTab(activeTabId);
        } else {
            // Default to first tab if none is stored
            setActiveTab('customer-info-tab');
        }
    });
</script>



@endsection
