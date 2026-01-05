<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'nis',
            'nama',
            'kelas',
            'jurusan',
        ];
    }
}
