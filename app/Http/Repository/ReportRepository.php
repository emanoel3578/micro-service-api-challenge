<?php

namespace App\Http\Repository;

use App\Models\Report;

class ReportRepository
{
  protected Report $model;

  public function __construct()
  {
    $this->model = new Report();
  }

  public function getReportQuery($id): array
  {
    $result = $this->model->select('sql')->find($id);
    
    if (empty($result)) {
      return [];
    }

    return $result->toArray();
  }
}