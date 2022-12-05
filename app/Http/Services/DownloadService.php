<?php

namespace App\Http\Services;

use DateTime;

class DownloadService 
{
  protected int $id;
  protected DateTime $dateStart;
  protected DateTime $dateEnd;

  public function setId(Int $id): void
  {
    $this->id = $id;
  }

  public function setDateStart(DateTime $dateStart): void
  {
    $this->dateStart = $dateStart;
  }

  public function setDateEnd(DateTime $dateEnd): void
  {
    $this->dateEnd = $dateEnd;
  }
}