<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 09:39
 */

namespace Useless\Validator\Contract;

/**
 * Interface ValidationInterface
 * @package Validator\Contract
 */
interface ValidationInterface
{
    /**
     * @param $value
     * @return boolean|string
     */
    public function validate($value);
}