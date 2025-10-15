<?php

namespace App\Exports;

use App\Models\UserSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UserSheetsExport implements FromCollection, WithHeadings
{
    protected $sheetCode;
    protected $snd;
    protected $includeStatus;
    protected $excludeStatus;
    protected $includeStatus2;
    protected $excludeStatus2;

    public function __construct($sheetCode, $snd, $includeStatus, $excludeStatus, $includeStatus2, $excludeStatus2)
    {
        $this->sheetCode = $sheetCode;
        $this->snd = $snd;
        $this->includeStatus = $includeStatus;
        $this->excludeStatus = $excludeStatus;
        $this->includeStatus2 = $includeStatus2;
        $this->excludeStatus2 = $excludeStatus2;
    }

    public function collection()
    {
        $query = UserSheet::query();

        if ($this->sheetCode) {
            $query->where('sheet_code', 'LIKE', "%{$this->sheetCode}%");
        }

        if ($this->snd) {
            $query->where('snd', 'LIKE', "%{$this->snd}%");
        }

        if (!empty($this->includeStatus)) {
            $query->whereIn('status', $this->includeStatus);
        }

        if (!empty($this->excludeStatus)) {
            $query->whereNotIn('status', $this->excludeStatus);
        }

        if (!empty($this->includeStatus2)) {
            $query->whereIn('status_2', $this->includeStatus2);
        }

        if (!empty($this->excludeStatus2)) {
            $query->whereNotIn('status_2', $this->excludeStatus2);
        }

        return $query->get();
    }
    public function headings(): array
    {
        return [
            ' ',
            'nper',
            'snd',
            'snd_group',
            'nama_cli',
            'alamat',
            'ubis',
            'desc_newbill',
            'usage_desc',
            'lama_berlangganan',
            'saldo',
            'no_hp',
            'email',
            'tanggal_caring_1',
            'petugas',
            'status',
            'tanggal_caring_2',
            'petugas_2',
            'status_2',
            'additional_info',
            'sheet_code',
            ' ',
            ' ',
            'branch',
            'sto',
            'status_paid',
            'totag',         // Integer attribute
            'payment_date',  // Add payment_date
        ];
    }
}
