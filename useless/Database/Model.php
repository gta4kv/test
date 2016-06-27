<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 17:58
 */

namespace Useless\Database;


/**
 * Class Model
 * @package Useless\Database
 */
abstract class Model
{
    /**
     * @var Database
     */
    protected $database;
    /**
     * @var
     */
    protected $table;
    /**
     * @var
     */
    protected $fields;
    /**
     * @var string
     */
    protected $primary = 'id';
    
}