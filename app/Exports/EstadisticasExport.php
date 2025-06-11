<?php

namespace App\Exports;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class EstadisticasExport implements FromCollection, WithHeadings, WithStyles
{
    protected $estadisticas;

    public function __construct($estadisticas)
    {
        $this->estadisticas = $estadisticas;
    }

    public function collection()
    {
        return collect($this->estadisticas)->map(function ($item) {
            return [
                'Mes' => $item['mes'],
                'Producto / Detalle' => $item['producto'],
                'Plan' => round($item['plan'], 2),
                'Real' => round($item['real'], 2),
                'Cumplimiento (%)' => $item['cumplimiento'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mes',
            'Producto / Detalle',
            'Plan',
            'Real',
            'Cumplimiento (%)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

    // Estilo general para encabezado
    $sheet->getStyle('A1:E1')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => [
            'bottom' => ['borderStyle' => Border::BORDER_THICK, 'color' => ['rgb' => '000000']],
        ],
    ]);

    for ($row = 2; $row <= $highestRow; $row++) {
        $productoCell = $sheet->getCell("B$row")->getValue();

        if ($productoCell === 'TOTAL GENERAL' || $productoCell === strtoupper($productoCell)) {
            // Filas resumen con borde superior más marcado
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']],
                'borders' => [
                    'top' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '444444']],
                ],
            ]);
        } else {
            // Filas detalle con borde superior delicado gris claro
            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'borders' => [
                    'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']],
                ],
            ]);

            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9F9F9']],
                ]);
            }

            // Alineación
            $sheet->getStyle("C{$row}:E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }
    }

    // Formato porcentaje para columna "Cumplimiento (%)"
    $sheet->getStyle('E2:E' . $highestRow)
        ->getNumberFormat()
        ->setFormatCode('0.00"%"');

    return [];
    }

    public function withColumnWidths(): array
    {
        return [
            'A' => 15, 
            'B' => 40, 
            'C' => 18,  
            'D' => 18, 
            'E' => 18, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ajustar altura de filas si quieres, ejemplo fila 1
                $sheet->getRowDimension(1)->setRowHeight(25);

                // Fijar paneles (cabecera)
                $sheet->freezePane('A2');
            },
        ];
    }
}