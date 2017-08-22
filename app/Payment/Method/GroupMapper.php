<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 21:06
 */

namespace App\Payment\Method;


use Useless\Database\MappableObject;
use Useless\Database\Mapper;

class GroupMapper extends Mapper
{
    protected $fields = ['id', 'name'];
    protected $tableName = 'payment_method_groups';

    /**
     * @param $object
     * @return MappableObject
     */
    protected function mapObject($object)
    {
        return (new Group())
            ->setId($object['id'])
            ->setName($object['name']);
    }

    public function delete($id)
    {
        throw new \Exception('Not implemented yet');
    }

    public function create(MappableObject $object)
    {
        throw new \Exception('Not implemented yet');
    }

    public function update(MappableObject $object)
    {
        throw new \Exception('Not implemented yet');
    }
}