<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 19:18
 */

namespace App\Player\Mapper;


use App\Player\Player;
use Useless\Database\Database;
use Useless\Database\MappableObject;
use Useless\Database\Mapper;

/**
 * Class AdminMapper
 * @package App\Player\Mapper
 */
class PlayerMapper extends Mapper
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * @param $email
     * @param $password
     * @return Player|null
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
     * @param $object
     * @return Player
     */
    protected function mapObject($object)
    {
        return (new Player($this))
            ->setId($object['id'])
            ->setEmail($object['email'])
            ->setPassword($object['password']);
    }

    /**
     * @param $email
     * @return Player|null
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