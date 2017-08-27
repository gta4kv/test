<?php
namespace Useless\Validator\Validators;

use Useless\Validator\AbstractValidator;
use Useless\Validator\Contract\ValidationInterface;

/**
 * Class LengthValidator
 * @package Validator\Validators
 */
class IntegerValidator extends AbstractValidator implements ValidationInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        if (!is_int($value)) {
            return ' should be an integer';
        }

        if ($min = $this->getParam('min')) {
            if ($value < $min) {
                return " should be more than {$min}";
            }
        }

        if ($max = $this->getParam('max')) {
            if ($value > $max) {
                return " should be less than {$max}";
            }
        }

        return true;
    }
}