<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSheet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {    // Retrieve filters from the request
        $year = $request->input('year');
        $month = $request->input('month');
        $petugas = $request->input('petugas');
        $sheet_code = $request->input('sheet_code');
        $status = $request->input('status');
        $date = $request->input('date');
        $status_paid = $request->input('status_paid'); // Add status_paid filter
        $branch = $request->input('branch'); // Add branch filter
        $sto = $request->input('sto'); // Add sto filter
        $excludedSheetCode = urldecode($request->input('ex_sheet_code'));
        $excludedSheetCodes = $excludedSheetCode ? explode(',', $excludedSheetCode) : [];
        
    
        // Apply filters if provided
        $filters = [];
    
        if ($year) {
            $filters[] = ['tanggal_caring_1', 'like', "$year%"];
        }
        if ($month) {
            $filters[] = [DB::raw('MONTH(tanggal_caring_1)'), '=', $month];
        }
        if ($petugas) {
            $filters[] = ['petugas', '=', $petugas];
        }
        if ($sheet_code) {
            $filters[] = ['sheet_code', '=', $sheet_code];
        }
        if ($status) {
            $filters[] = ['status', '=', $status];
        }
        if ($date) {
            $filters[] = [DB::raw('DATE(tanggal_caring_1)'), '=', $date];
        }
        if ($status_paid) {
            $filters[] = ['status_paid', '=', $status_paid];
        }
        if ($branch) {
            $filters[] = ['branch', '=', $branch];
        }
        if ($sto) {
            $filters[] = ['sto', '=', $sto];
        }
    
        // Build the query with the filters
        $query = UserSheet::query();
    
        foreach ($filters as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }
    
        // Exclude the specified sheet codes if provided
        if ($excludedSheetCodes) {
            $query->whereNotIn('sheet_code', $excludedSheetCodes);
        }
    

        // Get data for total number of customers and total saldo
        $totalCustomer = $query->count('snd');
        $totalSaldo = $query->sum('saldo');

        // Get category data for the chart
        $categoryData = $query->clone() // Clone query to avoid affecting other queries
            ->select('sheet_code', DB::raw('count(*) as count'))
            ->groupBy('sheet_code')
            ->get();

        // Get customer status grouping
        $customerStatus = $query->clone()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Get customer count by petugas
        $customerByPetugas = $query->clone()
            ->select('petugas', DB::raw('count(*) as count'))
            ->groupBy('petugas')
            ->get();

        // Get customer count by date
        $dateCustomerCount = $query->clone()
            ->select(DB::raw('DATE(tanggal_caring_1) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('YEAR(tanggal_caring_1)'), DB::raw('MONTH(tanggal_caring_1)'), DB::raw('DATE(tanggal_caring_1)'))
            ->orderBy(DB::raw('YEAR(tanggal_caring_1)'), 'asc')
            ->orderBy(DB::raw('MONTH(tanggal_caring_1)'), 'asc')
            ->orderBy(DB::raw('DATE(tanggal_caring_1)'), 'asc')
            ->get()
            ->filter(function ($item) {
                // Filter out items with empty or invalid dates
                return !empty($item->date) && strtotime($item->date) !== false;
            })
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date)->format('Y-m-d');
                return $item;
            });

        // Get raw data for sunburst chart
        $sunburstData = $query->clone()
            ->select('branch', 'sto', 'status_paid', 'totag')
            ->get()
            ->groupBy('status_paid')
            ->mapWithKeys(function ($group, $statusPaid) {
                return [$statusPaid => $group->groupBy('branch')
                    ->mapWithKeys(function ($branchGroup, $branch) {
                        return [$branch => $branchGroup->groupBy('sto')
                            ->mapWithKeys(function ($stoGroup, $sto) {
                                return [$sto => [
                                    'total' => $stoGroup->sum('totag'),
                                    'count' => $stoGroup->count('snd'), // Include count of `snd`
                                ]];
                            })
                            ->toArray()
                        ];
                    })
                    ->toArray()
                ];
            })
            ->toArray();

        // Get chart data
// Clone the query and get the raw data
$rawChartData = $query->clone()
    ->select(DB::raw('DATE(FROM_DAYS(payment_date - 2) - INTERVAL 1 YEAR) as payment_date'), 'branch', DB::raw('SUM(totag) as totag'))
    ->groupBy(DB::raw('DATE(FROM_DAYS(payment_date - 2) - INTERVAL 1 YEAR)'), 'branch')
    ->orderBy(DB::raw('DATE(FROM_DAYS(payment_date - 2) - INTERVAL 1 YEAR)'), 'asc')
    ->get();

// Filter out entries with empty or null dates
$filteredChartData = $rawChartData->filter(function ($item) {
    return !empty($item->payment_date) && $item->payment_date !== '0000-00-00';
});

// Calculate percentage growth
$percentageGrowth = [];
$previousTotal = null;

foreach ($filteredChartData->groupBy('payment_date') as $date => $dataGroup) {
    $totalForDate = $dataGroup->sum('totag');
    if ($previousTotal !== null && $previousTotal !== 0) {
        $growth = (($totalForDate - $previousTotal) / $previousTotal) * 100;
    } else {
        $growth = null; // No growth for the first date
    }
    $percentageGrowth[] = ['date' => $date, 'growth' => $growth];
    $previousTotal = $totalForDate;
}

// Structure the data for the bar chart
$barChartData = $filteredChartData->groupBy('branch')->map(function ($group) {
    return [
        'dates' => $group->pluck('payment_date'),
        'totag' => $group->pluck('totag'),
    ];
});


        // Pass all data to the view
        return view('user_sheet.dashboard', [
            'sunburstData' => $sunburstData,
            'totalCustomer' => $totalCustomer,
            'totalSaldo' => $totalSaldo,
            'categoryData' => $categoryData,
            'customerStatus' => $customerStatus,
            'customerByPetugas' => $customerByPetugas,
            'dateCustomerCount' => $dateCustomerCount,
            'barChartData' => $barChartData,
            'percentageGrowth' => $percentageGrowth,
        ]);
    }
}
