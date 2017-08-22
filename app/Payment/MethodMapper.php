<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 21:09
 */

namespace App\Payment;


use Useless\Database\MappableObject;
use Useless\Database\Mapper;

class MethodMapper extends Mapper
{
    protected $tableName = 'payment_methods';

    protected $fields = ['id', 'name', 'group_id'];

    /**
     * @param $object
     * @return MappableObject
     */
    protected function mapObject($object)
    {
        return (new Method())
            ->setName($object['name'])
            ->setId($object['id'])
            ->setGroupId($object['group_id']);
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