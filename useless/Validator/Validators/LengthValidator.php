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
 * Class LengthValidator
 * @package Validator\Validators
 */
class LengthValidator extends AbstractValidator implements ValidationInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        $length = mb_strlen($value);

        if ($min = $this->getParam('min')) {
            if ($length < $min) {
                return "should not be less than {$min} chars";
            }
        }

        if ($max = $this->getParam('max')) {
            if ($length > $max) {
                return "should not be more than {$max} chars";
            }
        }

        return true;
    }
}