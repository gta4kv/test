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
 * Class RequiredValidator
 * @package Validator\Validators
 */
class RequiredValidator extends AbstractValidator implements ValidationInterface
{
    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        if (!$value) {
            return 'should be entered';
        }

        return true;
    }
}