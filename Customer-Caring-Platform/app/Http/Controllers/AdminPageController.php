<?php

namespace App\Http\Controllers;

use App\Models\UserSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{
    public function manageSheetCodes(Request $request)
    {
        // Retrieve search term from query parameters
        $searchSnd = $request->query('search_snd');
    
        // Fetch sheet codes and counts separately
        $sheetCodes = UserSheet::select('sheet_code', DB::raw('COUNT(*) as count'))
            ->groupBy('sheet_code')
            ->get();
    
        // Separate variables for sheet codes and counts
        $codes = $sheetCodes->pluck('sheet_code');
        $counts = $sheetCodes->pluck('count');
    
        // Fetch SND records if available
        $sndRecords = $searchSnd ? UserSheet::where('snd', $searchSnd)->get() : collect();
    
        return view('user_sheet.adminpage', compact('codes', 'counts', 'sndRecords', 'searchSnd'));
    }
    
    

    // Update a specific sheet_code
    public function updateSheetCode(Request $request, $sheet_code)
    {
        $validated = $request->validate([
            'new_sheet_code' => 'required|string|max:255',
        ]);

        // Update all records with the old sheet_code to the new one
        UserSheet::where('sheet_code', $sheet_code)
            ->update(['sheet_code' => $validated['new_sheet_code']]);

        return redirect()->route('user_sheet.adminpage')->with('success', 'Sheet Code updated successfully!');
    }
        public function deleteSheetCode($sheet_code)
    {
        // Delete all records with the selected sheet_code
        UserSheet::where('sheet_code', $sheet_code)->delete();

        return redirect()->route('user_sheet.adminpage')->with('success', 'Sheet Code deleted successfully!');
    }
    
// Edit specific record using SND and sheet_code (for modal form)
public function editBySndAndSheetCode($snd, $sheet_code)
{
    $userSheet = UserSheet::where('snd', $snd)
                          ->where('sheet_code', $sheet_code)
                          ->firstOrFail();
                          
    return response()->json($userSheet);  // Return the record as JSON for modal editing
}

// Update record using SND and sheet_code
public function updateBySndAndSheetCode(Request $request, $snd, $sheet_code)
{
    $request->validate([
        'nper' => 'nullable|integer',
        'snd' => 'nullable|integer',
        'snd_group' => 'nullable|integer',
        'nama_cli' => 'nullable|string|max:255',
        'alamat' => 'nullable|string|max:255',
        'ubis' => 'nullable|string|max:255',
        'desc_newbill' => 'nullable|string|max:255',
        'usage_desc' => 'nullable|string|max:255',
        'lama_berlangganan' => 'nullable|integer',
        'saldo' => 'nullable|integer',
        'no_hp' => 'nullable|integer',
        'email' => 'nullable|string|max:255',
        'tanggal_caring_1' => 'nullable|string|max:255',
        'petugas' => 'nullable|string|max:255',
        'status' => 'nullable|string|in:JAWAB OKE, LUNAS/PAID, RNA, TIDAK AKTIF, REJECT, COMPLAIN',
        'tanggal_caring_2' => 'nullable|string|max:255',
        'petugas_2' => 'nullable|string|max:255',
        'status_2' => 'nullable|string|in:JAWAB OKE, LUNAS/PAID, RNA, TIDAK AKTIF, REJECT, COMPLAIN',
        'additional_info' => 'nullable|string|max:255',
        'sheet_code' => 'nullable|string|max:255',
    ]);

    $userSheet = UserSheet::where('snd', $snd)
                          ->where('sheet_code', $sheet_code)
                          ->firstOrFail();
    $userSheet->update($request->all());

    return redirect()->route('user_sheet.adminpage')->with('success', 'User Sheet updated successfully');
}

// Delete specific record using SND and sheet_code
public function deleteBySndAndSheetCode($snd, $sheet_code)
{
    $userSheet = UserSheet::where('snd', $snd)
                          ->where('sheet_code', $sheet_code)
                          ->firstOrFail();
    $userSheet->delete();

    return redirect()->route('user_sheet.adminpage')->with('success', 'Record deleted successfully');
}



    public function searchBySnd(Request $request)
    {
    $snd = $request->input('snd');


    // Perform search logic
    $sndRecords = UserSheet::where('snd', $snd)->get();

    // Fetch sheet codes and counts
    $sheetCodes = UserSheet::select('sheet_code', DB::raw('COUNT(*) as count'))
        ->groupBy('sheet_code')
        ->get();

    $codes = $sheetCodes->pluck('sheet_code');
    $counts = $sheetCodes->pluck('count');

    return view('user_sheet.adminpage', compact('sndRecords', 'codes', 'counts'));
    }

}
