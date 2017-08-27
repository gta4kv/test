<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 11:10
 */

namespace Useless\Support;

use Useless\Application;

/**
 * Class ServiceProvider
 * @package Useless\Support
 */
abstract class ServiceProvider
{
    /**
     * @return mixed
     */
    abstract public function register();
}