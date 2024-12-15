<?php

namespace App\Exports;

use App\Models\Imrad;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class FileDataExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $imrads;

    public function __construct($imrads)
    {
        $this->imrads = $imrads;
    }

    public function array(): array
    {

        $count = 1;
        return $this->imrads->map(function ($imrad) use (&$count) {
            return [
                'id' => $count++,
                'category' => $imrad->category,
                'title' => $imrad->title,
                'author' => $imrad->author,
                'adviser' => $imrad->adviser,
                'abstract' => $imrad->abstract,
                'Year' => $imrad->publication_date,
                'Call#' => $imrad->location,
            ];
        })->toArray();

    }

    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Title',
            'Author',
            'Adviser',
            'Abstract',
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
            'A' => 5,  // ID
            'B' => 20, // Title
            'C' => 50, // Title
            'D' => 20, // Author
            'E' => 25, // Adviser
            'F' => 100, // Abstract
            'G' => 10, // Year
            'H' => 15, // Call#
        ];
    }

}
