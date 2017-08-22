<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:31
 */

namespace App\Player\Mapper;


use App\Player\Player;
use Useless\Database\Database;
use useless\Database\MappableObject;
use useless\Database\Mapper;

/**
 * Class PlayerMapper
 * @package App\Player\Mapper
 */
class PlayerMapper extends Mapper
{
    /**
     * @var array
     */
    private $fields = [
        'id', 'username', 'first_name', 'last_name', 'email', 'birth_date', 'created_by'
    ];

    /**
     * PlayerMapper constructor.
     * @param Database $database
     */


    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = 'delete from players where id = :id';

        $this->database->queryPrepared($sql, [
            'id' => $id
        ]);

        return true;
    }

    /**
     * @param MappableObject|Player $player
     * @return bool
     */
    public function create(MappableObject $player)
    {
        $sql = "insert into players (" . implode(', ', $this->fields) . ") VALUES (NULL, :username, :firstName, :lastName, :email, :birthDate, :createdBy)";

        $this->database->queryPrepared($sql, [
            'username' => $player->getUsername(),
            'firstName' => $player->getFirstName(),
            'lastName' => $player->getLastName(),
            'email' => $player->getEmail(),
            'birthDate' => $player->getBirthDate(true),
            'createdBy' => $player->getCreatedBy()
        ]);

        return true;
    }

    /**
     * @param MappableObject|Player $player
     * @return bool
     */
    public function update(MappableObject $player)
    {
        $sql = "UPDATE players SET username = :username, first_name = :firstName, last_name = :lastName, email = :email, birth_date = :birthDate WHERE id = :id";

        $this->database->queryPrepared($sql, [
            'username' => $player->getUsername(),
            'firstName' => $player->getFirstName(),
            'lastName' => $player->getLastName(),
            'email' => $player->getEmail(),
            'birthDate' => $player->getBirthDate(true),
            'id' => $player->getId()
        ]);

        return true;
    }



    /**
     * @param $object
     * @return MappableObject|Player
     */
    protected function mapObject($object)
    {
        return (new Player())
            ->setId($object['id'])
            ->setUsername($object['username'])
            ->setEmail($object['email'])
            ->setFirstName($object['first_name'])
            ->setLastName($object['last_name'])
            ->setBirthDate($object['birth_date'])
            ->setCreatedBy($object['created_by']);
    }
}