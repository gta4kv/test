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

        $sql = 'select ' . implode(', ', $this->fields) . " from players where {$field} {$operator} :value";

        $query = $this->database->queryPrepared($sql, [
            'value' => $value
        ]);

        $results = $one === true ? (array)$query->one() : $query->all();

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