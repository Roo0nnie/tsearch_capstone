<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class UserDataExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function array(): array
    {

        return $this->user->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'user_code' => $user->user_code,
                'email' => $user->email,
                'phone' => $user->phone,
                'updated_at' => $user->updated_at,

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
