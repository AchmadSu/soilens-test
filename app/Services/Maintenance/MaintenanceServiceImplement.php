<?php

namespace App\Services\Maintenance;

use LaravelEasyRepository\Service;
use App\Repositories\Maintenance\MaintenanceRepository;
use App\Repositories\Tool\ToolRepository;
use Illuminate\Support\Facades\DB;

class MaintenanceServiceImplement extends Service implements MaintenanceService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;
  protected $toolRepository;

  public function __construct(
    MaintenanceRepository $mainRepository,
    ToolRepository $toolRepository,
  ) {
    $this->mainRepository = $mainRepository;
    $this->toolRepository = $toolRepository;
  }

  public function createMaintenance($data)
  {
    try {
      return DB::transaction(function () use ($data) {
        $totalOrderAmount = 0;
        foreach ($data['tools'] as $tool) {
          $price = $tool['price'];
          $totalOrderAmount += $price;
          $this->toolRepository->setToolStatus((int)$tool['id'], 'repair');
        }
        $array = [
          'requester_id' => auth()->user()->id,
          'start_date' => $data['start_date'],
          'end_date' => $data['end_date'],
          'total_amount' => $totalOrderAmount,
        ];
        return $this->mainRepository->createMaintenance($array);
      });
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function setMaintenanceStatus($id, $status)
  {
    try {
      return DB::transaction(function () use ($id, $status) {
        $activeTool = ['completed', 'cancelled'];
        $toolStatus = in_array($status, $activeTool) ? 'active' : 'repair';
        $maintenance = $this->mainRepository->findByID((int)$id);
        $tools = $maintenance->items();

        foreach ($tools as $tool) {
          $this->toolRepository->setToolStatus((int)$tool['id'], $toolStatus);
        }
        return $this->mainRepository->updateMaintenanceStatus($id, $status);
      });
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
