<?php

namespace App\Http\Entities;

use Carbon\Carbon;

class RawSql
{
  protected String $rawSql;
  protected ?Carbon $dateStart = null;
  protected ?Carbon $dateEnd = null;

  public function getFormatedFilters(): string
  {
    return $this->formatRawSql();
  }

  public function getFormatedSql(): String
  {
    return $this->formatRawSql();
  }

  public function setFilters(?string $dateStart, ?string $dateEnd): void
  {
    $this->dateStart = Carbon::parse($dateStart);
    $this->dateEnd = Carbon::parse($dateEnd);
  }

  public function setRawSql(String $rawSql): void
  {
    $this->rawSql = $rawSql;
  }

  public function getBindings(): array
  {
    return $this->mountBindings();
  }

  private function getDateTimeStringByType(string $dateType): String
  {
    if ($dateType === 'start') {
      return $this->dateStart->toDateTimeString();
    }

    if ($dateType === 'end') {
      return $this->dateEnd->toDateTimeString();
    }

    return '';
  }

  private function formatRawSql(): String
  {
    if ($this->dateStart) {
      $formatedSql = $this->rawSql . ' where t.created_at >= ?';
    }

    if ($this->dateEnd) {
      $formatedSql = $this->rawSql . ' where t.created_at <= ?';
    }

    if ($this->dateStart && $this->dateEnd) {
      $formatedSql = $this->rawSql . ' where t.created_at between ? and ?';
    }

    return $formatedSql;
  }

  private function mountBindings(): array
  {
    if ($this->dateStart) {
      $bindings = [$this->getDateTimeStringByType('start')];
    }

    if ($this->dateEnd) {
      $bindings = [$this->getDateTimeStringByType('end')];
    }

    if ($this->dateStart && $this->dateEnd) {
      $bindings = [$this->getDateTimeStringByType('start'), $this->getDateTimeStringByType('end')];
    }

    return $bindings;
  }
}