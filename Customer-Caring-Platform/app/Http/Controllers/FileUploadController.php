<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserSheetImport;
use App\Imports\UserSheetPreviewImport;
use Illuminate\Support\Facades\Session;

class FileUploadController extends Controller
{
    public function showUploadForm(Request $request)
    {
        $previewData = session('previewData', []);
        $fileName = session('fileName');
        $sheetCode = session('sheet_code');

        return view('user_sheet.upload', [
            'previewData' => $previewData,
            'fileName' => $fileName,
            'sheet_code' => $sheetCode,
        ]);
    }

    public function handleFileUpload(Request $request)
    {
        $action = $request->input('action');

        // Handle reset action
        if ($action === 'reset') {
            Session::forget(['previewData', 'preview', 'fileName', 'sheet_code']);
            return redirect()->route('user_sheet.file.upload');
        }

        // Validate the input
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048',
            'sheet_code' => 'required|string|max:255',
        ]);

        // Check if file is uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $sheetCode = $request->input('sheet_code');
            $fileName = $file->getClientOriginalName();

            if ($action === 'preview') {
                // Handle file preview
                set_time_limit(120); // Set max execution time to 120 seconds for this method
                $previewData = Excel::toArray(new UserSheetPreviewImport, $file);

                // Store preview data in session
                Session::put('previewData', $previewData);
                Session::put('preview', true);
                Session::put('fileName', $fileName);
                Session::put('sheet_code', $sheetCode);
            } elseif ($action === 'upload') {
                // Handle actual file upload logic here
                set_time_limit(300); // Set max execution time to 300 seconds for this method
                // Move the file to a storage location
                $file->storeAs('uploads', $fileName);

                // Process the file using Excel import
                Excel::import(new UserSheetImport($sheetCode), $file);

                // Reset preview data
                Session::forget(['previewData', 'preview', 'fileName', 'sheet_code']);

                return redirect()->route('user_sheet.file.upload')->with('success', 'File uploaded and processed successfully.');
            }
        } else {
            // Handle the case where no file is uploaded
            return redirect()->back()->withErrors(['file' => 'No file uploaded']);
        }

        return redirect()->route('user_sheet.file.upload');
    }
}
