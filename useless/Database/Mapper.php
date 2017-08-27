<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 20:39
 */

namespace Useless\Database;


use InvalidArgumentException;

abstract class Mapper
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var array
     */
    private $cache;

    /**
     * Mapper constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param $id
     * @return MappableObject
     */
    public function findById($id)
    {
        return $this->findByAny('id', $id, '=');
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     * @param boolean $one
     *
     * @return MappableObject|MappableObject[]
     */
    public function findByAny($field, $value, $operator, $one = true)
    {
        $this->preCheck($field);

        if ($operator == 'like') {
            $value = "%{$value}%";
        }

        $sql = 'select ' . implode(', ', $this->fields) . " from {$this->getTableName()} where {$field} {$operator} :value";

        $cacheKey = md5($sql . $value . $one);

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $query = $this->database->queryPrepared($sql, [
            'value' => $value
        ]);

        $results = $one === true ? $query->one() : $query->all();

        if (!$results) {
            return null;
        }

        $results = (array)$results;
        $output = null;

        if ($one === true) {
            $output = $this->mapObject($results);
        } else {
            $output = [];

            foreach ($results as $result) {
                $output[] = $this->mapObject($result);
            }
        }

        $this->cache[$cacheKey] = $output;

        return $output;
    }

    /**
     * @param string $field
     *
     * @throws InvalidArgumentException
     */
    private function preCheck($field)
    {
        if (!$this->tableName) {
            throw new InvalidArgumentException('Table name is not set in ' . __CLASS__);
        }

        if (!$this->fields) {
            throw new InvalidArgumentException('Fields are not defined in ' . __CLASS__);
        }

        if (!$this->isExistingField($field)) {
            throw new InvalidArgumentException("Field [$field] is unknown in " . __CLASS__);
        }
    }

    /**
     * @param $field
     * @return bool
     */
    public function isExistingField($field)
    {
        return in_array($field, $this->fields);
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param $object
     * @return MappableObject
     */
    abstract protected function mapObject($object);

    /**
     * @return MappableObject|MappableObject[]
     */
    public function findAll()
    {
        return $this->findByAny('id', '0', '>', false);
    }

    abstract public function delete($id);

    abstract public function create(MappableObject $object);

    abstract public function update(MappableObject $object);
}