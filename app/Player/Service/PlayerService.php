<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:31
 */

namespace App\Player\Service;


use App\Player\Mapper\PlayerMapper;
use App\Player\Player;

/**
 * Class PlayerService
 * @package App\Player\Service
 */
class PlayerService
{
    /**
     * @var string
     */
    private $field;
    /**
     * @var string
     */
    private $value;
    /**
     * @var string
     */
    private $operator;

    /**
     * @var PlayerMapper
     */
    protected $mapper;

    /**
     * @var array
     */
    private $allowed = [
        '=', '<>', '>', '<', 'like'
    ];

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     * @return \App\Player\Player|\App\Player\Player[]
     */
    public function searchByAny($field = 'id', $value = '0', $operator = '>')
    {
        $this->setField($field)
            ->setOperator($operator)
            ->setValue($value);

        return $this->find(false);
    }

    /**
     * PlayerService constructor.
     * @param PlayerMapper $mapper
     */
    public function __construct(PlayerMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function createOrUpdate(Player $player)
    {
        if ($player->isNewRecord()) {
            return $this->create($player);
        } else {
            return $this->update($player);
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    private function create(Player $player)
    {
        return $this->mapper->create($player);
    }

    /**
     * @param Player $player
     * @return bool
     */
    private function update(Player $player)
    {
        return $this->mapper->update($player);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->mapper->delete($id);
    }

    /**
     * @param $id
     * @return \App\Player\Player|\App\Player\Player[]
     */
    public function findById($id)
    {
        $this->setField('id')
            ->setOperator('=')
            ->setValue($id);

        return $this->find();
    }

    public function findByUsername($username)
    {
        $this->setField('username')
            ->setOperator('=')
            ->setValue($username);

        return $this->find();
    }

    /**
     * @param bool $one
     * @return \App\Player\Player|\App\Player\Player[]
     */
    public function find($one = true)
    {
        if (!$this->isAllowedOperator($this->getOperator())) {
            throw new \InvalidArgumentException("Operator [{$this->getOperator()}] is unknown");
        }

        return $this->mapper->findByAny($this->getField(), $this->getValue(), $this->getOperator(), $one);
    }

    /**
     * @param $operator
     * @return bool
     */
    protected function isAllowedOperator($operator)
    {
        return in_array($operator, $this->allowed);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }
}