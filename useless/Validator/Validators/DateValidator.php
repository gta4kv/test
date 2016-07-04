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
 * Class DateValidator
 * @package Validator\Validators
 */
class DateValidator implements ValidationInterface
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
        $time = \DateTime::createFromFormat('d.m.Y', $value);

        if (!$time) {
            return ' is incorrect date format';
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