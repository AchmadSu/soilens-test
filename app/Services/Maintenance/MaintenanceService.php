<?php

namespace App\Services\Maintenance;

use LaravelEasyRepository\BaseService;

interface MaintenanceService extends BaseService
{

    public function createMaintenance($data);
    public function setMaintenanceStatus($id, $status);
}
