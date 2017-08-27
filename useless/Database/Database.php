<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:53
 */

namespace Useless\Database;


use Useless\Application;
use Useless\Database\Engine\EngineInterface;

/**
 * Class Database
 * @package Useless\Database
 */
class Database
{
    /**
     * @var EngineInterface
     */
    protected $engine;


    /**
     * Database constructor.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;

        $this->connect();
    }

    private function connect()
    {
        $config = config()->get('database');

        $this->engine->connect($config);
    }

    /**
     * @param $sql
     * @param array $parameters
     * @return EngineInterface
     */
    public function queryPrepared($sql, array $parameters = [])
    {
        return $this->engine->queryPrepared($sql, $parameters);
    }

    /**
     * @param $sql
     * @return EngineInterface
     */
    public function query($sql)
    {
        return $this->engine->query($sql);
    }
}