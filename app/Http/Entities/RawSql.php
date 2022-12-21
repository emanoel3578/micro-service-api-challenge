<?php

namespace App\Http\Entities;

use Carbon\Carbon;
use Exception;

class RawSql
{
  protected String $rawSql;
  protected ?Carbon $dateStart = null;
  protected ?Carbon $dateEnd = null;

  public function getFormatedSql(): string
  {
    return $this->formatRawSql()->formatedSql;
  }
  
  public function getBindings(): array
  {
    return $this->formatRawSql()->bindings;
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

  public function checkIfRawSqlParametersAreCorrect(): void
  {
    if ($this->rawSqlHasDateStartParameter() && !$this->dateStart) {
      throw new Exception('The report query has a dateStart parameter but it was not given a valid value', 402);
    }

    if ($this->rawSqlHasDateEndParameter() && !$this->dateEnd) {
      throw new Exception('The report query has a dateEnd parameter but it was not given a valid value', 402);
    }
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

  public function rawSqlHasDateStartParameter(): bool
  {
    return str_contains($this->rawSql, 'dateStart');
  }

  public function rawSqlHasDateEndParameter(): bool
  {
    return str_contains($this->rawSql, 'dateEnd');
  }

  public function formatRawSql(): object
  {
    $formatedSqlWithBindings = (object) [
      'formatedSql' => $this->rawSql,
      'bindings' => []
    ];

    if (($this->rawSqlHasDateStartParameter() && $this->dateStart) && ($this->rawSqlHasDateEndParameter() && $this->dateEnd)) {
      $formatedSqlWithBindings->formatedSql = str_replace(['dateStart', 'dateEnd'], ['?', '?'], $this->rawSql);
      $formatedSqlWithBindings->bindings = [$this->getDateTimeStringByType('start'), $this->getDateTimeStringByType('end')];
      return $formatedSqlWithBindings;
    }

    if ($this->rawSqlHasDateStartParameter() && $this->dateStart) {
      $formatedSqlWithBindings->formatedSql = str_replace('dateStart', '?', $this->rawSql);
      $formatedSqlWithBindings->bindings = [$this->getDateTimeStringByType('start')];
      return $formatedSqlWithBindings;
    }

    if ($this->rawSqlHasDateEndParameter() && $this->dateEnd) {
      $formatedSqlWithBindings->formatedSql = str_replace('dateEnd', '?', $this->rawSql);
      $formatedSqlWithBindings->bindings = [$this->getDateTimeStringByType('end')];
      return $formatedSqlWithBindings;
    }
    
    return $formatedSqlWithBindings;
  }
}