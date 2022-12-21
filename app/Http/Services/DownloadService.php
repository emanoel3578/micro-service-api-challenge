<?php

namespace App\Http\Services;

use App\Http\Entities\RawSql;
use App\Http\Repository\ReportRepository;
use App\Models\Report;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class DownloadService
{
  protected int $id;
  protected RawSql $rawSql;

  public function __construct(ReportRepository $repository)
  {
    $this->repository = $repository;
    $this->rawSql = new RawSql();
  }

  public function getReportData(array $params): array
  {
    $this->setId($params);
    $this->setDateParamsInRawSql($params);
    $this->mountReportQuery();
    return $this->getFinalData();
  }

  private function setId(array $params): void
  {
    if (empty($params['id'])) { 
      throw new Exception('Something went wrong with the given id', 500);
    }

    $this->id = $params['id'];
  }

  public function setDateParamsInRawSql(array $params): void
  {
    $dateStart = array_key_exists('dateStart', $params) ? $params['dateStart'] : null;
    $dateEnd = array_key_exists('dateEnd', $params) ? $params['dateEnd']  : null;
    $this->rawSql->setFilters($dateStart, $dateEnd);
  }

  private function mountReportQuery(): void
  {
    $resultedRawSql = $this->repository->getReportQuery($this->id);

    if (!$resultedRawSql) {
      throw new Exception('Id was not found', 404);
    }
    
    $this->rawSql->setRawSql($resultedRawSql['sql']);
    $this->rawSql->checkIfRawSqlParametersAreCorrect();
  }

  private function getFinalData(): array
  {
    $formatedSql = $this->rawSql->getFormatedSql();
    $bindings = $this->rawSql->getBindings();
   
    if (!$formatedSql) {
      return [];
    }

    return $this->repository->executeSql($formatedSql, $bindings);
  }
}
