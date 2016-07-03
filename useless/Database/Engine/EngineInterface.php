<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:54
 */

namespace Useless\Database\Engine;


/**
 * Interface EngineInterface
 * @package Useless\Database\Engine
 */
interface EngineInterface
{
    /**
     * @param $sql
     * @param bool $one
     * @return mixed
     */
    public function query($sql, $one = false);

    /**
     * @param $config
     * @return mixed
     */
    public function connect($config);

    /**
     * @param $sql
     * @param array $parameters
     * @return mixed
     */
    public function queryPrepared($sql, $parameters = []);

    /**
     * @return mixed
     */
    public function one();

    /**
     * @return mixed
     */
    public function all();
}