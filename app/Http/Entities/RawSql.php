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

  public function setFilters(?string $dateStart = '', ?string $dateEnd = ''): void
  {
    $this->dateStart = $dateStart ? Carbon::parse($dateStart) : null;
    $this->dateEnd = $dateEnd ? Carbon::parse($dateEnd) : null;
  }

  public function setRawSql(String $rawSql): void
  {
    $this->rawSql = $rawSql;
  }

  public function getBindings(): array
  {
    return $this->mountBindings();
  }

  public function getDateTimeStringByType(string $dateType): String
  {
    if ($dateType === 'start') {
      return $this->dateStart->toDateTimeString();
    }

    if ($dateType === 'end') {
      return $this->dateEnd->toDateTimeString();
    }

    return '';
  }

  public function formatRawSql(): String
  {
    if(!$this->dateStart && !$this->dateEnd) {
      $formatedSql = $this->rawSql;
    }

    if (!empty($this->dateStart)) {
      $formatedSql = $this->rawSql . ' where t.created_at >= ?';
    }

    if (!empty($this->dateEnd)) {
      $formatedSql = $this->rawSql . ' where t.created_at <= ?';
    }

    if (!empty($this->dateStart) && !empty($this->dateEnd)) {
      $formatedSql = $this->rawSql . ' where t.created_at between ? and ?';
    }

    return $formatedSql;
  }

  public function mountBindings(): array
  {
    if(!$this->dateStart && !$this->dateEnd) {
      $bindings = [];
    }

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