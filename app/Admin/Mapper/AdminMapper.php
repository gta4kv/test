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

/**
 * Class AdminMapper
 * @package App\Admin\Mapper
 */
class AdminMapper
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * AdminMapper constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param $email
     * @param $password
     * @return Admin|null
     */
    public function findByEmailAndPassword($email, $password)
    {
        $user = $this->database->queryPrepared(
            "select id, email, password from admins where email = :email and password = :password",
            compact('email', 'password')
        )->one();

        if (!$user) {
            return null;
        }

        return $this->mapObject($user);
    }

    /**
     * @param $email
     * @return Admin|null
     */
    public function findByEmail($email)
    {
        $user = $this->database->queryPrepared(
            "select id, email, password from admins where email = :email",
            compact('email')
        )->one();

        if (!$user) {
            return null;
        }

        return $this->mapObject($user);
    }

    /**
     * @param array $row
     * @return Admin
     */
    protected function mapObject(array $row)
    {
        $entry = new Admin($this);
        $entry->setId($row['id'])
            ->setEmail($row['email'])
            ->setPassword($row['password']);

        return $entry;
    }
}