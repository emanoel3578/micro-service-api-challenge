<?php

namespace App\Http\Entities;

use Carbon\Carbon;

class RawSql
{
  protected String $rawSql;
  protected ?Carbon $dateStart = null;
  protected ?Carbon $dateEnd = null;

  public function getFormatedFilters(): array
  {
    return $this->formatFilters();
  }

  public function getFormatedSql(): String
  {
    return $this->formatRawSql();
  }

  public function setFilters(?Carbon $dateStart, ?Carbon $dateEnd): void
  {
    $this->dateStart = $dateStart;
    $this->dateEnd = $dateEnd;
  }

  public function setRawSql(String $rawSql): void
  {
    $this->rawSql = $rawSql;
  }

  private function formatRawSql(): String
  {
    if (!str_contains($this->rawSql, 'dateEnd') || !str_contains($this->rawSql, 'dateStart')) {
      $formatedSql = $this->rawSql;
    }

    if (str_contains($this->rawSql, 'dateStart') && str_contains($this->rawSql, 'dateEnd')) {
      $formatedSql = str_replace(['dateStart', 'dateEnd'], '?', $this->rawSql);
    }

    return $formatedSql;
  }

  private function formatFilters(): array
  {
    $filters = [];

    if (str_contains($this->rawSql, 'dateStart') && str_contains($this->rawSql, 'dateEnd')) {
      array_push($filters, $this->dateStart->toDateTimeString());
      array_push($filters, $this->dateEnd->toDateTimeString());
    }

    return $filters;
  }
}