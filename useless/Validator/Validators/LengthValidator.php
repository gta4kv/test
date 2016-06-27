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
 * Class LengthValidator
 * @package Validator\Validators
 */
class LengthValidator implements ValidationInterface
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
        $length = mb_strlen($value);

        if ($min = $this->getParam('min')) {
            if ($length < $min) {
                return "should be not less than {$min} chars";
            }
        }

        if ($max = $this->getParam('max')) {
            if ($length > $max) {
                return "should be not more that {$max} chars";
            }
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

    /**
     * @param $name
     * @return bool
     */
    public function getParam($name)
    {
        return (isset($this->params[$name])) ? $this->params[$name] : false;
    }
}