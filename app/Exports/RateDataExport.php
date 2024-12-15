<?php

namespace App\Exports;

use App\Models\Imrad;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class RateDataExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $imrads;

    public function __construct($imrads)
    {
        $this->imrads = $imrads->load('imradMetric');
    }

    public function array(): array
    {

        $count = 1;
        return $this->imrads->map(function ($imrad) use (&$count) {
            return [
                '#' => $count++,
                'Category' => $imrad->category ?? '',
                'Title' => $imrad->title ?? '',
                'Authors' => $imrad->author ?? '',
                'Advisers' => $imrad->adviser ?? '',
                'Downloads' => $imrad->imradMetric && isset($imrad->imradMetric->downloads) ? $imrad->imradMetric->downloads : 0,
                'Rates' => $imrad->imradMetric && isset($imrad->imradMetric->rates) ? $imrad->imradMetric->rates : 0,
                'Year' => $imrad->publication_date ?? '',
                'Call#' => $imrad->location ?? '',
            ];
        })->toArray();

    }

    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Title',
            'Authors',
            'Advisers',
            'Downloads',
            'Rates',
            'Year',
            'Call#',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
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
            'C' => 50,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 10,
            'I' => 15,
        ];
    }

}
