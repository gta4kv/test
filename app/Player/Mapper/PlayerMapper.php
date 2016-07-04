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

/**
 * Class PlayerMapper
 * @package App\Player\Mapper
 */
class PlayerMapper
{
    /**
     * @var Database
     */
    protected $database;

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
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param $id
     * @return null
     */
    public function findById($id)
    {
        return $this->findByAny('id', $id, '=');
    }

    /**
     * @return Player|\App\Player\Player[]
     */
    public function findAll()
    {
        return $this->findByAny('id', '0', '>', false);
    }

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
     * @param Player $player
     * @return bool
     */
    public function create(Player $player)
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
     * @param Player $player
     * @return bool
     */
    public function update(Player $player)
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
     * @param string $field
     * @param string $value
     * @param string $operator
     * @param boolean $one
     *
     * @return Player|Player[]
     */
    public function findByAny($field, $value, $operator, $one = true)
    {
        if (!$this->isExistingField($field)) {
            throw new \InvalidArgumentException("Field [$field] is unknown in the context of Player");
        }

        if ($operator == 'like') {
            $value = "%{$value}%";
        }

        $sql = 'select ' . implode(', ', $this->fields) . " from players where {$field} {$operator} :value";

        $query = $this->database->queryPrepared($sql, [
            'value' => $value
        ]);

        $results = $one === true ? $query->one() : $query->all();

        if (!$results) {
            return null;
        }

        $results = (array) $results;

        if ($one === true) {
            return $this->mapObject($results);
        }

        $output = [];

        foreach ($results as $result) {
            $output[] = $this->mapObject($result);
        }

        return $output;
    }

    /**
     * @param $row
     * @return $this
     */
    private function mapObject($row)
    {
        return (new Player())
            ->setId($row['id'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setFirstName($row['first_name'])
            ->setLastName($row['last_name'])
            ->setBirthDate($row['birth_date'])
            ->setCreatedBy($row['created_by']);
    }

    /**
     * @param $field
     * @return bool
     */
    public function isExistingField($field)
    {
        return in_array($field, $this->fields);
    }
}