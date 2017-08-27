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
use Useless\Database\MappableObject;
use Useless\Database\Mapper;

/**
 * Class PlayerMapper
 * @package App\Player\Mapper
 */
class PlayerMapper extends Mapper
{
    /**
     * @var array
     */
    protected $fields = [
        'id', 'full_name', 'password', 'email', 'current_balance'
    ];

    /**
     * @var string
     */
    protected $tableName = 'players';

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
        $sql = "insert into players (" . implode(', ', $this->fields) . ") VALUES (NULL, :fullName, :password, :email, :currentBalance)";

        $this->database->queryPrepared($sql, [
            'fullName' => $player->getFullName(),
            'email' => $player->getEmail(),
            'password' => password_hash($player->getPassword(), PASSWORD_BCRYPT),
            'currentBalance' => 5.0
        ]);

        return true;
    }

    /**
     * @param MappableObject|Player $player
     * @return bool
     */
    public function update(MappableObject $player)
    {
        return false;
    }



    /**
     * @param $object
     * @return MappableObject|Player
     */
    protected function mapObject($object)
    {
        return (new Player())
            ->setId($object['id'])
            ->setEmail($object['email'])
            ->setFullName($object['full_name'])
            ->setPassword($object['password'])
            ->setCurrentBalance($object['current_balance']);
    }
}