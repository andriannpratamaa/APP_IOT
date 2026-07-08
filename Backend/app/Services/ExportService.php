<?php

namespace App\Services;

use App\Exports\MonitoringExport;
use App\Models\User;
use App\Repositories\ExportHistoryRepository;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    public function __construct(
        protected ExportHistoryRepository $exportHistoryRepository,
    ) {}

    public function export(array $params, User $user): string
    {
        $fileName = sprintf(
            'monitoring_%s_%s.xlsx',
            $params['start_date'],
            $params['end_date']
        );

        $this->exportHistoryRepository->create([
            'user_id' => $user->id,
            'file_name' => $fileName,
            'period_start' => $params['start_date'],
            'period_end' => $params['end_date'],
        ]);

        $export = new MonitoringExport($params);
        $fullPath = 'exports/' . $fileName;

        Excel::store($export, $fullPath, 'public');

        return $fullPath;
    }
}
