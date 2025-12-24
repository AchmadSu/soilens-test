<?php

namespace App\Repositories\Tool;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Tool;
use Exception;
use Illuminate\Support\Facades\Cache;

class ToolRepositoryImplement extends Eloquent implements ToolRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Tool $model)
    {
        $this->model = $model;
    }

    public function getAvailableTools()
    {
        try {
            $tools = $this->model
                ->where('status', 'active')
                ->paginate($param['paginate'] ?? 8);
            return $tools;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getRepairTools()
    {
        try {
            $tools = $this->model
                ->where('status', 'repair')
                ->paginate($param['paginate'] ?? 8);
            return $tools;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getInactiveTools()
    {
        try {
            $tools = $this->model
                ->where('status', 'inactive')
                ->paginate($param['paginate'] ?? 8);
            return $tools;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function setToolStatus(int $toolId, string $status)
    {

        try {
            $acceptance = ['active', 'repair', 'inactive'];
            if (!in_array($status, $acceptance)) {
                throw new Exception("Wrong status data", 400);
            }

            $tool = $this->model->first($toolId);
            if ($status === 'inactive' || $status === 'repair') {
                $isActive = $tool->status === 'active';
                if (!$isActive) {
                    throw new Exception("Inactive or repair status only accept for the only active status", 400);
                }
            }

            $tool->status = $status;
            $tool->save();
            return $tool->refresh();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
