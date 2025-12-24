<?php

namespace App\Repositories\Maintenance;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MaintenanceRepositoryImplement extends Eloquent implements MaintenanceRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Maintenance $model)
    {
        $this->model = $model;
    }

    public function findByID(int $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createMaintenance(array $data)
    {
        if (empty($data['code'])) {
            $data['code'] = 'INV-' . Str::upper(Str::random(8));
        }
        $data['expired_at'] = Carbon::now()->addDay(1);

        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateMaintenanceStatus(int $id, string $status)
    {
        try {
            $maintenance = $this->model->findOrFail($id);
            $maintenance->status = $status;
            $maintenance->acceptance_id = auth()->user()->id;
            $maintenance->save();
            return $maintenance;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
