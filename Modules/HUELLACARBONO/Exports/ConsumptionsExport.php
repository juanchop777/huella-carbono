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

class ConsumptionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $consumptions;
    protected $title;

    public function __construct($consumptions, $title = 'Consumos')
    {
        $this->consumptions = $consumptions;
        $this->title = $title;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->consumptions;
    }

    /**
     * Encabezados de las columnas
     */
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

    /**
     * Mapear los datos de cada fila
     */
    public function map($consumption): array
    {
        return [
            $consumption->id,
            $consumption->consumption_date->format('d/m/Y'),
            $consumption->productiveUnit->name ?? 'N/A',
            $consumption->emissionFactor->name ?? 'N/A',
            number_format($consumption->quantity, 2),
            $consumption->emissionFactor->unit ?? '',
            number_format($consumption->co2_generated, 3),
            $consumption->registeredBy->nickname ?? 'Sistema',
            $consumption->observations ?? '-'
        ];
    }

    /**
     * Estilos de la hoja
     */
    public function styles(Worksheet $sheet)
    {
        // Estilo de encabezados
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10b981']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Auto-tamaño de columnas
        foreach(range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Altura de fila de encabezado
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Bordes para toda la tabla
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:I{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ]
        ]);

        // Alternar colores de filas
        for ($i = 2; $i <= $lastRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle("A{$i}:I{$i}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F9FAFB']
                    ]
                ]);
            }
        }

        return [];
    }

    /**
     * Título de la hoja
     */
    public function title(): string
    {
        return $this->title;
    }
}





