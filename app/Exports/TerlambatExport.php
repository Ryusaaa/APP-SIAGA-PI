<?php

namespace App\Exports;

use App\Models\SuratTerlambat;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TerlambatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $jurusanId;
    protected $interval;
    protected $startDate;
    protected $endDate;

    public function __construct($jurusanId = null, $interval = 'all', $startDate = null, $endDate = null)
    {
        $this->jurusanId = $jurusanId;
        $this->interval = $interval;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = SuratTerlambat::with(['siswa', 'kelas', 'jurusan']);

        // Apply date filtering
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        // Apply jurusan filtering
        if ($this->jurusanId) {
            $query->where('jurusan_id', $this->jurusanId);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        // 1. Determine Jurusan Name
        $jurusanName = 'SEMUA JURUSAN';
        if ($this->jurusanId) {
            $jurusan = Jurusan::find($this->jurusanId);
            if ($jurusan) {
                $jurusanName = strtoupper($jurusan->nama);
            }
        }

        // 2. Determine Period Text
        $periodText = 'SEMUA PERIODE';
        if ($this->startDate && $this->endDate) {
            if ($this->startDate->format('Y-m-d') === $this->endDate->format('Y-m-d')) {
                $periodText = 'TANGGAL: ' . $this->startDate->format('d/m/Y');
            } else {
                $periodText = 'PERIODE: ' . $this->startDate->format('d/m/Y') . ' - ' . $this->endDate->format('d/m/Y');
            }
        } elseif ($this->interval === 'all') {
            $periodText = 'SEMUA PERIODE';
        }

        return [
            ['LAPORAN DATA KETERLAMBATAN SISWA'],               // Row 1: Title
            ['JURUSAN: ' . $jurusanName . ' | ' . $periodText], // Row 2: Subtitle
            [''],                                               // Row 3: Empty space
            [                                                   // Row 4: Table Headers
                'NIS',
                'Nama',
                'Kelas',
                'Jurusan',
                'Alasan',
                'Jam Masuk',
                'Tanggal',
            ]
        ];
    }

    public function map($terlambat): array
    {
        return [
            $terlambat->siswa->nis ?? '-',
            $terlambat->siswa->nama ?? '-',
            $terlambat->siswa->kelas ?? '-',
            $terlambat->siswa->jurusan ?? '-',
            $terlambat->alasan ?? '-',
            $terlambat->jamMasuk ?? '-',
            $terlambat->created_at->format('d/m/Y'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // NIS
            'B' => 25,  // Nama
            'C' => 10,  // Kelas
            'D' => 30,  // Jurusan
            'E' => 35,  // Alasan
            'F' => 20,  // Jam Masuk
            'G' => 15,  // Tanggal
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 4; // +4 because headers are now at row 4

        // --- MERGE TITLE CELLS ---
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        // --- STYLE ROW 1 (MAIN TITLE) ---
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // --- STYLE ROW 2 (SUBTITLE) ---
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '555555'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // --- STYLE ROW 4 (TABLE HEADERS) ---
        $sheet->getStyle('A4:G4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'], // Blue background
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // --- STYLE DATA ROWS (Starts from Row 5) ---
        $sheet->getStyle('A5:G' . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center align specific columns
        $sheet->getStyle('A5:A' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // NIS
        $sheet->getStyle('C5:C' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Kelas
        $sheet->getStyle('F5:F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Jam Masuk
        $sheet->getStyle('G5:G' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tanggal

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(30); // Title row
        $sheet->getRowDimension(2)->setRowHeight(20); // Subtitle row
        $sheet->getRowDimension(4)->setRowHeight(25); // Header row

        return [];
    }
}
