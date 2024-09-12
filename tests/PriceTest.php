<?php

namespace App\Phpunit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Price;

class PriceTest extends TestCase
{
    private $target;
    public function setUp() :void{
        parent::setUp();

        $this->target = new Price();
    }

    #[DataProvider('getIncludeTaxPriceProvider')]
    /**
     * 価格に消費税を足した金額を計算 のテスト
     * @param int $testPrice
     * @param bool $testIsReducedTaxItem
     * @param int $expected
     * @return void
     */
    public function testGetIncludeTaxPrice(
        int $testPrice,
        bool $testIsReducedTaxItem,
        int $expected,
    ) :void
    {
        $result = $this->target->getIncludeTaxPrice($testPrice, $testIsReducedTaxItem);
        $this->assertEquals($result, $expected);
    }

    public static function getIncludeTaxPriceProvider() :array
    {
        return [
            "正常系1-軽減税率(小数点でない場合)" => [
                "testPrice" => 10000,
                "testIsReducedTaxItem" => true,
                "expected" => 10800,
            ],
            "正常系2-通常税率(小数点でない場合)" => [
                "testPrice" => 10000,
                "testIsReducedTaxItem" => false,
                "expected" => 11000,
            ],
            "正常系3-軽減税率(小数点の場合)" => [
                "testPrice" => 12345,
                "testIsReducedTaxItem" => true,
                "expected" => 13333,
            ],
            "正常系4-通常税率(小数点の場合)" => [
                "testPrice" => 12345,
                "testIsReducedTaxItem" => false,
                "expected" => 13580,
            ],
        ];
    }

    #[DataProvider('getFloatToIntPriceProvider')]
    /**
     * 小数点以下を四捨五入し金額を返す のテスト
     * @param float $testPrice
     * @param int $expected
     * @return void
     */
    public function testGetFloatToIntPrice(float $testPrice, int $expected)
    {
        $result = $this->target->getFloatToIntPrice($testPrice);
        $this->assertEquals($result, $expected);
    }

    public static function getFloatToIntPriceProvider() :array
    {
        return [
            "正常系1" => [
                "testPrice" => 10000.4,
                "expected" => 10000,
            ],
            "正常系2" => [
                "testPrice" => 10000.5,
                "expected" => 10001,
            ],
            "正常系3" => [
                "testPrice" => 10000.49,
                "expected" => 10000,
            ],
            "正常系4" => [
                "testPrice" => 10000.51,
                "expected" => 10001,
            ],
        ];
    }
}
