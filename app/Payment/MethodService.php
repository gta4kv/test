<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 21:14
 */

namespace App\Payment;


use Useless\Database\Queryable;

/**
 * Class MethodService
 * @package app\Payment
 */
class MethodService
{
    use Queryable;

    public function __construct(MethodMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}