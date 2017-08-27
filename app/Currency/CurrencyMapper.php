<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/08/2017
 * Time: 21:02
 */

namespace App\Currency;


use Useless\Database\MappableObject;
use Useless\Database\Mapper;

class CurrencyMapper extends Mapper
{
    /**
     * @var string
     */
    protected $tableName = 'currencies';

    /**
     * @var array
     */
    protected $fields = ['id', 'name'];

    /**
     * @param $object
     * @return MappableObject
     */
    protected function mapObject($object)
    {
        return (new Currency())
            ->setId($object['id'])
            ->setName($object['name']);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function create(MappableObject $object)
    {
        // TODO: Implement create() method.
    }

    public function update(MappableObject $object)
    {
        // TODO: Implement update() method.
    }
}