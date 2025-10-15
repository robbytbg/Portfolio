<?php

namespace App\Imports;

use App\Models\UserSheet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UserSheetImport implements ToModel, WithHeadingRow
{
    protected $sheetCode;

    public function __construct($sheetCode)
    {
        $this->sheetCode = $sheetCode;
    }

    public function model(array $row)
    {
        return new UserSheet([
            'nper' => $row['nper'],
            'snd' => $row['snd'],
            'snd_group' => $row['snd_group'],
            'nama_cli' => $row['nama_cli'],
            'alamat' => $row['alamat'],
            'ubis' => $row['ubis'],
            'desc_newbill' => $row['desc_newbill'],
            'usage_desc' => $row['usage_desc'],
            'lama_berlangganan' => $this->sanitizeLamaBerlangganan($row['lama_berlangganan']),
            'saldo' => $this->sanitizeSaldo($row['saldo']),
            'no_hp' => $row['no_hp'] ?: null,
            'email' => $row['email'] ?: null,
            'tanggal_caring_1' => $this->convertDate($row['tanggal_caring_1']),
            'petugas' => $row['petugas'],
            'status' => $row['status'],
            'tanggal_caring_2' => $this->convertDate($row['tanggal_caring_2']),
            'petugas_2' => $row['petugas_2'],
            'status_2' => $row['status_2'],
            'additional_info' => $row['additional_info'],
            'sheet_code' => $this->sheetCode, // Add the sheet_code to each row
            'branch'=> $row['branch'],
            'sto'=> $row['sto'],
            'status_paid'=> $row['status_paid'],  // Add status_paid
            'totag'=> $row['totag'] ?: null,         // Integer attribute
            'payment_date'=> $row['payment_date'],  // Add payment_date
        ]);
    }

    private function sanitizeSaldo($value)
    {
        // Remove any non-numeric characters
        $sanitized_value = preg_replace('/[^\d]/', '', $value);
        return (int)$sanitized_value;  // Convert to integer
    }

    private function sanitizeLamaBerlangganan($value)
    {
        // Remove any non-numeric characters and trim
        $sanitized_value = preg_replace('/[^\d]/', '', $value);
        return (int)$sanitized_value;  // Convert to integer
    }

    private function convertDate($value)
    {
        if (is_numeric($value)) {
            try {
                // Convert Excel serial date to DateTime object and format it
                return Date::excelToDateTimeObject($value)->format('Y-m-d'); // Adjust format as needed
            } catch (\Exception $e) {
                // Handle conversion exception
                return 'Invalid Date';
            }
        }
        return $value; // If not numeric, return as is (assuming it's a valid date string)
    }
}
