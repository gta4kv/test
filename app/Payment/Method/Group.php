<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 20:31
 */

namespace App\Payment\Method;


use Useless\Database\MappableObject;

class Group implements MappableObject
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNewRecord()
    {
        return null === $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}