<?php

require 'vendor/autoload.php';

use Carbon\Carbon;

class OriginDateTime {
    public $now = null;
    public $startDate = null;
    public $endDate = null;

    /**
     * コンストラクタ
     *
     * @param Carbon $now
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(Carbon $now, string $startDate, string $endDate)
    {
        $this->now = $now;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * 開始日時を取得
     *
     * @return Carbon
     */
    public function getStartDate() :Carbon
    {
        return $this->getDate($this->startDate);
    }

    /**
     * 終了日を取得
     *
     * @return Carbon
     */
    public function getEndDate() :Carbon
    {
        return $this->getDate($this->endDate);
    }

    /**
     * 日付を作成して取得
     *
     * @param string $date
     * @return Carbon
     */
    private function getDate(string $date) :Carbon
    {
        return Carbon::parse($this->now->year . $date);
    }

    /**
     * 現在日付と取得して期間に含まれているかを取得
     *
     * @return bool
     */
    public function isCompare() :bool
    {
        return $this->now->between($this->getStartDate(), $this->getEndDate());
    }
}

$originDateTime = new OriginDateTime(Carbon::now(), "/02/01", "/04/30");
$originDateTimeCorrect = new OriginDateTime(Carbon::parse("2024/04/01"), "/02/01", "/04/30");
$originDateTimeInCorrect = new OriginDateTime(Carbon::parse("2024/04/30 15:15:15.123456"), "/02/01", "/04/30");
$originDateTimeInCorrectToCorrect = new OriginDateTime(Carbon::parse("2024/04/30 15:15:15.123456"), "/02/01 00:00:00.000000", "/04/30 23:59:59.999999");

var_dump(
    $originDateTime->isCompare(),
    $originDateTimeCorrect->isCompare(),
    $originDateTimeInCorrect->isCompare(),
    $originDateTimeInCorrectToCorrect->isCompare()
);
