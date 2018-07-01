<?php
/**
 * Created by PhpStorm.
 * User: tamat
 * Date: 01.07.18
 * Time: 12:52
 */

namespace App\Http;

class Helpers
{
    /**
     * @param int $value
     * @return string
     */
    public static function longToMoney(int $value)
    {
        $money = $value / 100;
        $money = number_format($money, 2);

        return $money;
    }

    /**
     * @param string $value
     * @return string
     */
    public static function moneyToLong(string $value)
    {
        $money = $value * 100;

        return $money;
    }
}