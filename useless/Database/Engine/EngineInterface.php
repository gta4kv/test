<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:54
 */

namespace Useless\Database\Engine;


interface EngineInterface
{
    public function query($sql, $one = false);
    public function connect($config);
    public function queryPrepared($sql, $parameters = []);

    public function one();
    public function all();
}