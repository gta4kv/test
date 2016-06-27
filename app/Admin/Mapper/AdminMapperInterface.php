<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:22
 */

namespace App\Admin\Mapper;

interface AdminMapperInterface
{
    public function getByEmailAndPassword($email, $password);
}