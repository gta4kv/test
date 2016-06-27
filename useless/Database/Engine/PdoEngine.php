<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 16:54
 */

namespace Useless\Database\Engine;

use PDO;

/**
 * Class PdoEngine
 * @package Useless\Database\Engine
 */
class PdoEngine implements EngineInterface
{
    /**
     * @var PDO
     */
    private $connection;

    private $query;

    public function query($sql, $one = false)
    {
        $this->query = $this->connection->query($sql);

        return $this;
    }

    public function queryPrepared($sql, $parameters = [])
    {
        $this->query = $this->connection->prepare($sql);

        $this->query->execute($parameters);

        return $this;
    }

    public function one()
    {
        if ($this->query) {
            return $this->query->fetch();
        }

        return null;
    }

    public function all()
    {
        if ($this->query) {
            return $this->query->fetchAll();
        }

        return null;
    }

    /**
     * @param $config
     */
    public function connect($config)
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";

        $this->connection = new PDO($dsn, $config['user'], $config['password']);
    }
}