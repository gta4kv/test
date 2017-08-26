<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 09:40
 */

namespace Useless\Validator\Validators;

use Useless\Validator\AbstractValidator;
use Useless\Validator\Contract\ValidationInterface;

/**
 * Class DateValidator
 * @package Validator\Validators
 */
class DateValidator extends AbstractValidator implements ValidationInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        $time = \DateTime::createFromFormat('d.m.Y', $value);

        if (!$time) {
            return ' is incorrect date format';
        }

        return true;
    }
}