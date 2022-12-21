<?php

namespace App\Http\Repository;

use App\Models\Report;
use Illuminate\Support\Facades\DB;

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

  public function executeSql(String $sql, array $bindings): array
  {
    return DB::select($sql, $bindings);
  }
}