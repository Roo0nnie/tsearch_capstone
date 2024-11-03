<?php

namespace App\Exports;

use App\Models\LogHistory;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class LogHistoryExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $logHistory;

    public function __construct($logHistory)
    {
        $this->logHistory = $logHistory;
    }

    public function array(): array
    {

        return $this->logHistory->map(function ($logHistory) {
            return [
                'id' => $logHistory->id,
                'code' => $logHistory->user_code,
                'name' => $logHistory->name,
                'role' => $logHistory->user_type,
                'login' => $logHistory->login,
                'logout' => $logHistory->logout,
                'last_update' => $logHistory->updated_at,
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            '#',
            'Code',
            'Name',
            'Role',
            'Login',
            'Logout',
            'Last Update',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font style to the header row
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {

        return [
            'A' => 5,
            'B' => 15,
            'C' => 25,
            'D' => 15,
            'E' => 20,
            'F' => 20,
            'G' => 25,
        ];
    }

}
