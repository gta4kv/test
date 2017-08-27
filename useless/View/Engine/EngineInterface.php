<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:28
 */

namespace Useless\View\Engine;


/**
 * Interface EngineInterface
 * @package Useless\View\Engine
 */
interface EngineInterface
{
    /**
     * @param $path
     * @param array $variables
     * @return string
     */
    public function get($path, array $variables = []);

    /**
     * @param string $path
     * @param string $alias
     * @return void
     */
    public function addPath($path, $alias);

    /**
     * @param string $var
     * @param string $value
     * @return void
     */
    public function addGlobal($var, $value);
}