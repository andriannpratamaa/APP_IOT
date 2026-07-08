<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AuthService $authService,
    ) {}

    public function index(): JsonResponse
    {
        $data = $this->authService->getDashboard();

        return $this->success(new DashboardResource($data));
    }
}
