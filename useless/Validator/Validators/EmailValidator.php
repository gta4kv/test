<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 09:40
 */

namespace Useless\Validator\Validators;

use Useless\Validator\Contract\ValidationInterface;

/**
 * Class EmailValidator
 * @package Validator\Validators
 */
class EmailValidator implements ValidationInterface
{
    /**
     * @var
     */
    private $params;

    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'should be a correct email address';
        }
        
        return true;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }
}