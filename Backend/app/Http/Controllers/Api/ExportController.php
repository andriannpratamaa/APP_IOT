<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExportRequest;
use App\Services\ExportService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ExportService $exportService,
    ) {}

    public function export(ExportRequest $request): BinaryFileResponse|JsonResponse
    {
        $filePath = $this->exportService->export(
            $request->validated(),
            $request->user()
        );

        $fullPath = Storage::disk('public')->path($filePath);

        if (!file_exists($fullPath)) {
            return $this->error('File export tidak ditemukan', null, 404);
        }

        return response()->download($fullPath, basename($filePath), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Access-Control-Expose-Headers' => 'Content-Disposition',
        ])->deleteFileAfterSend(true);
    }
}
