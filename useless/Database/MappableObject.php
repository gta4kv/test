<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 21/08/2017
 * Time: 20:43
 */

namespace Useless\Database;


interface MappableObject
{
    /**
     * @return boolean
     */
    public function isNewRecord();
}