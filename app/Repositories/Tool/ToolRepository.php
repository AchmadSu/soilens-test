<?php

namespace App\Repositories\Tool;

use LaravelEasyRepository\Repository;

interface ToolRepository extends Repository
{

    public function getAvailableTools();
    public function getRepairTools();
    public function getInactiveTools();
    public function setToolStatus(int $toolId, string $status);
}
