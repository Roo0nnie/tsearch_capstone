<?php

namespace App\Exports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class FacultyDataExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $faculty;

    public function __construct($faculty)
    {
        $this->faculty = $faculty;
    }

    public function array(): array
    {

        return $this->faculty->map(function ($faculty) {
            return [
                'id' => $faculty->id,
                'name' => $faculty->name,
                'user_code' => $faculty->user_code,
                'email' => $faculty->email,
                'phone' => $faculty->phone,
                'updated_at' => $faculty->updated_at,

            ];
        })->toArray();

    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Code',
            'Email',
            'Phone',
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
            'B' => 20,
            'C' => 15,
            'D' => 30,
            'E' => 20,
            'F' => 25,
        ];
    }

}
