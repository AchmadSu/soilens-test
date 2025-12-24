<?php

namespace App\Http\Controllers;

use App\Services\Maintenance\MaintenanceService;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    private $service;

    public function __construct(MaintenanceService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $required = ['start_date', 'end_date', 'tools'];
        $errorResponse = checkArrayRequired($data, $required);
        if ($errorResponse) return $errorResponse;

        $rules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:tools,id'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
        ];

        $errorResponse = validateFormData($data, $rules);

        if (!empty($errorResponse)) {
            return $errorResponse;
        };

        try {
            $data = $this->service->create($data);
            $response = successResponse("Create Maintenance successfully", $data);
            return response()->json($response, $response['status_code']);
        } catch (\Exception $e) {
            $response = errorResponse($e);
            return response()->json($response, $response['status_code']);
        }
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $required = ['id', 'status'];
        $errorResponse = checkArrayRequired($data, $required);
        if ($errorResponse) return $errorResponse;

        $rules = [
            'id' => 'required|integer|exists:maintenances,id',
            'status' => 'required|string|in:awaiting_verification,verified,on_repair,delayed,completed,cancelled',
        ];

        $errorResponse = validateFormData($data, $rules);

        if (!empty($errorResponse)) {
            return $errorResponse;
        };

        try {
            $data = $this->service->setMaintenanceStatus($data['id'], $data['status']);
            $response = successResponse("Set Maintenance Status successfully", $data);
            return response()->json($response, $response['status_code']);
        } catch (\Exception $e) {
            $response = errorResponse($e);
            return response()->json($response, $response['status_code']);
        }
    }
}
