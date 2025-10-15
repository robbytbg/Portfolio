<?php

namespace App\Http\Controllers;

use App\Models\UserSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{
    
    public function index(Request $request)
    {
        $query = UserSheet::query();
        $sheetCodes = UserSheet::distinct()->pluck('sheet_code')->sort()->values();

        // Filter by sheet code
        if ($request->has('sheet_code') && $request->input('sheet_code') != '') {
            $sheetCode = $request->input('sheet_code');
            $query->where('sheet_code', 'LIKE', "%{$sheetCode}%");
        }
    

        $userRoles = Auth::user()->roles->pluck('name');
        return view('user_sheet.index', compact('user_sheet', 'userRoles', 'sheetCodes'));
    }
    

}
