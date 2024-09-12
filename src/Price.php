<?php

namespace App;

class Price
{
    /**
     * 消費税
     * @var float
     */
    const TAX_RATE = 0.1;

    /**
     * 消費税
     * @var float
     */
    const REDUCED_TAX_RATE = 0.08;


    /**
     * 価格に消費税を足した金額を計算
     *
     * @param int $price
     * @param bool $isReducedTaxItem
     * @return int
     */
    public function getIncludeTaxPrice(int $price, bool $isReducedTaxItem): int
    {
        // 税率の設定
        $tax = $isReducedTaxItem ? self::REDUCED_TAX_RATE : self::TAX_RATE;
        // 販売価格（税込み）の金額を返す
        return $this->getFloatToIntPrice($price * (1.0 + $tax));
    }

    /**
     * 小数点以下を四捨五入し金額を返す
     *
     * @param float $price
     * @return int
     */
    public function getFloatToIntPrice(float $price) :int
    {
        return round($price);
    }
}
