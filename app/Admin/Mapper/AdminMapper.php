<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:18
 */

namespace App\Admin\Mapper;


use App\Admin\Admin;
use Useless\Database\Database;

class AdminMapper
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findByEmailAndPassword($email, $password)
    {
        $user = $this->database->queryPrepared(
            "select id, email, password from admins where email = :email and password = :password",
            compact('email', 'password')
        )->one();

        if (!$user) {
            return false;
        }

        return $this->mapObject($user);
    }
    
    protected function mapObject(array $row)
    {
        $entry = new Admin($this);
        $entry->setId($row['id'])
            ->setEmail($row['email'])
            ->setPassword($row['password']);

        return $entry;
    }
}