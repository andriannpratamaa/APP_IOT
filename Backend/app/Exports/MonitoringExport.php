<?php

namespace App\Exports;

use App\Models\Monitoring;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonitoringExport implements FromView, WithColumnWidths, WithStyles
{
    protected array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $query = Monitoring::with('device');

        if (!empty($this->params['device_id'])) {
            $query->where('device_id', $this->params['device_id']);
        }

        $query->where('recorded_at', '>=', $this->params['start_date'])
              ->where('recorded_at', '<=', $this->params['end_date'] . ' 23:59:59')
              ->orderBy('recorded_at');

        $data = $query->get();

        return view('exports.monitoring', [
            'monitorings' => $data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 10,
            'C' => 20,
            'D' => 15,
            'E' => 12,
            'F' => 15,
            'G' => 12,
            'H' => 12,
            'I' => 12,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
    }
}
