<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:31
 */

namespace App\Player\Service;


use App\Player\Mapper\PlayerMapper;

/**
 * Class PlayerService
 * @package App\Player\Service
 */
class PlayerService
{
    /**
     * @var PlayerMapper
     */
    protected $mapper;

    /**
     * @var array
     */
    private $allowed = [
        '=', '<>', '>', '<'
    ];

    /**
     * PlayerService constructor.
     * @param PlayerMapper $mapper
     */
    public function __construct(PlayerMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param $id
     * @return null
     */
    public function findById($id)
    {
        return $this->mapper->findById($id);

    }

    /**
     * @return \App\Player\Player|\App\Player\Player[]
     */
    public function findAll()
    {
        return $this->mapper->findAll();
    }

    /**
     * @param $field
     * @param $value
     * @param string $operator
     * @param bool $one
     * @return \App\Player\Player|\App\Player\Player[]
     */
    public function find($field, $value, $operator = '=', $one = true)
    {
        if (!$this->isAllowedOperator($operator)) {
            throw new \InvalidArgumentException("Operator [{$operator}] is unknown");
        }

        return $this->mapper->findByAny($field, $value, $operator, $one);
    }

    /**
     * @param $operator
     * @return bool
     */
    protected function isAllowedOperator($operator)
    {
        return in_array($operator, $this->allowed);
    }
}