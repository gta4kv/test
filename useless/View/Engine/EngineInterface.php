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
     * @return mixed
     */
    public function get($path, array $variables = []);
}