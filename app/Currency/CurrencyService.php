<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/08/2017
 * Time: 21:02
 */

namespace App\Currency;


use Useless\Database\Queryable;

/**
 * Class CurrencyService
 * @package App\Currency
 */
class CurrencyService
{
    use Queryable;

    /**
     * CurrencyService constructor.
     * @param CurrencyMapper $mapper
     */
    public function __construct(CurrencyMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}