<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    protected $guests;

    public function __construct($guests)
    {
        // Only select the desired columns
        $this->guests = $guests->map(function ($guest) {
            return [
                'nama' => $guest->nama,
                'instansi' => $guest->instansi,
                'kemana' => $guest->kemana,
                'waktu' => $guest->created_at->locale('id')->translatedFormat('d F Y') . ' / ' . $guest->created_at->format('H:i T')
            ];
        });
    }

    public function collection()
    {
        return collect($this->guests);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Dari',
            'Tujuan',
            'Waktu'
        ];
    }
}
