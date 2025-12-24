<?php

namespace App\Repositories\Maintenance;

use App\Models\Maintenance;
use LaravelEasyRepository\Repository;

interface MaintenanceRepository extends Repository
{

    public function findByID(int $id);
    public function createMaintenance(array $data);
    public function updateMaintenanceStatus(int $id, string $status);
}
