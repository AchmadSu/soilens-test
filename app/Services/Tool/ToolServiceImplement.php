<?php

namespace App\Services\Tool;

use LaravelEasyRepository\Service;
use App\Repositories\Tool\ToolRepository;

class ToolServiceImplement extends Service implements ToolService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(ToolRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAvailableTools()
  {
    try {
      return $this->mainRepository->getAvailableTools();
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function getRepairTools()
  {
    try {
      return $this->mainRepository->getRepairTools();
    } catch (\Exception $e) {
      throw $e;
    }
  }

  public function getInactiveTools()
  {
    try {
      return $this->mainRepository->getInactiveTools();
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
