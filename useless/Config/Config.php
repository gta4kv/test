<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 17:10
 */

namespace Useless\Config;

/**
 * Class Config
 * @package Useless\Config
 */
class Config
{
    /**
     * @var
     */
    protected $configs;

    /**
     * @param $section
     * @return mixed
     * @throws \Exception
     */
    public function get($section)
    {
        if (!$this->configs[$section]) {
            $this->configs[$section] = $this->load($section);
        }

        return $this->configs[$section];
    }

    /**
     * @param $section
     * @return mixed
     * @throws \Exception
     */
    private function load($section)
    {
        $path = app()->basePath . "/config/{$section}.php";

        if (!file_exists($path)) {
            throw new \Exception("Can not locate config [{$section}] in path [{$path}]");
        }

        return require_once $path;
    }
}