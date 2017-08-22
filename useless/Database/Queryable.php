<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 20:34
 */

namespace Useless\Database;

trait Queryable
{
    /**
     * @var string
     */
    private $field;
    /**
     * @var string
     */
    private $value;
    /**
     * @var string
     */
    private $operator;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var array
     */
    private $allowed = [
        '=', '<>', '>', '<', 'like'
    ];

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return MappableObject|MappableObject[]
     */
    public function searchByAny($field = 'id', $value = '0', $operator = '>')
    {
        $this->setField($field)
            ->setOperator($operator)
            ->setValue($value);

        return $this->find(false);
    }

    /**
     * @param MappableObject $object
     * @return bool
     */
    public function createOrUpdate(MappableObject $object)
    {
        if ($object->isNewRecord()) {
            return $this->create($object);
        } else {
            return $this->update($object);
        }
    }

    /**
     * @param MappableObject $object
     * @return bool
     */
    private function create(MappableObject $object)
    {
        return $this->mapper->create($object);
    }

    /**
     * @param MappableObject $object
     * @return bool
     */
    private function update(MappableObject $object)
    {
        return $this->mapper->update($object);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->mapper->delete($id);
    }

    /**
     * @param $id
     * @return MappableObject|MappableObject[]
     */
    public function findById($id)
    {
        $this->setField('id')
            ->setOperator('=')
            ->setValue($id);

        return $this->find();
    }

    /**
     * @return MappableObject|MappableObject[]
     */
    public function findAll()
    {
        return $this->mapper->findAll();
    }

    /**
     * @param bool $one
     * @return MappableObject|MappableObject[]
     */
    private function find($one = true)
    {
        if (!$this->isAllowedOperator($this->getOperator())) {
            throw new \InvalidArgumentException("Operator [{$this->getOperator()}] is unknown");
        }

        return $this->mapper->findByAny($this->getField(), $this->getValue(), $this->getOperator(), $one);
    }

    /**
     * @param $operator
     * @return bool
     */
    protected function isAllowedOperator($operator)
    {
        return in_array($operator, $this->allowed);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }
}