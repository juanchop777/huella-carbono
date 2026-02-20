<?php

namespace Modules\HUELLACARBONO\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * Exportación de consumos por query (streaming): evita cargar todos los registros en memoria.
 */
class ConsumptionsFromQueryExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /** @var Builder */
    protected $query;
    protected $title;

    public function __construct(Builder $query, $title = 'Consumos')
    {
        $this->query = $query;
        $this->title = $title;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Unidad Productiva',
            'Variable/Factor',
            'Cantidad',
            'Unidad',
            'CO₂ Generado (kg)',
            'Registrado Por',
            'Observaciones'
        ];
    }

    public function map($row): array
    {
        $date = $row->consumption_date;
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }
        return [
            $row->id,
            $date->format('d/m/Y'),
            $row->unit_name ?? 'N/A',
            $row->factor_name ?? 'N/A',
            number_format((float) $row->quantity, 2),
            $row->factor_unit ?? '',
            number_format((float) $row->co2_generated, 3),
            $row->registered_by_nickname ?? 'Sistema',
            $row->observations ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10b981']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
        ]);
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(25);
        $lastRow = $sheet->getHighestRow();
        if ($lastRow >= 1) {
            $sheet->getStyle("A1:I{$lastRow}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]]
            ]);
        }
        return [];
    }

    public function title(): string
    {
        return $this->title;
    }
}
