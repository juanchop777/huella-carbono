<?php

namespace Modules\HUELLACARBONO\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ByFactorExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $consumptions;

    public function __construct($consumptions)
    {
        $this->consumptions = $consumptions;
    }

    public function collection()
    {
        $byFactor = $this->consumptions->groupBy('emission_factor_id')->map(function ($items) {
            return (object) [
                'factor_name' => $items->first()->emissionFactor->name ?? 'N/A',
                'count' => $items->count(),
                'total_co2' => $items->sum('co2_generated'),
            ];
        })->sortByDesc('total_co2')->values();
        return $byFactor;
    }

    public function headings(): array
    {
        return ['Factor de Emisión', 'Registros', 'Total CO₂ (kg)'];
    }

    public function map($row): array
    {
        return [
            $row->factor_name,
            $row->count,
            number_format($row->total_co2, 3),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $range = 'A1:C' . max(1, $lastRow);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10b981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(25);
        if ($lastRow >= 1) {
            $sheet->getStyle($range)->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
            ]);
            for ($i = 2; $i <= $lastRow; $i++) {
                if ($i % 2 == 0) {
                    $sheet->getStyle("A{$i}:C{$i}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9FAFB']],
                    ]);
                }
            }
        }
        return [];
    }

    public function title(): string
    {
        return 'Por Factor de Emisión';
    }
}
