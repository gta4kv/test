<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 21:14
 */

namespace App\Payment\Method;


use Useless\Database\Queryable;

/**
 * Class GroupService
 * @package App\Payment\Method
 */
class GroupService
{
    use Queryable;

    public function __construct(GroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}