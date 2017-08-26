<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/08/2017
 * Time: 18:22
 */

namespace Useless\Validator;


/**
 * Class AbstractValidator
 * @package Useless\Validator
 */
abstract class AbstractValidator
{
    /**
     * @var array
     */
    private $params;

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