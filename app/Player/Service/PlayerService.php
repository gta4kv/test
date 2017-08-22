<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:22
 */

namespace App\Player\Service;


use App\Player\Mapper\PlayerMapper;
use App\Player\Player;
use Useless\Database\Queryable;

/**
 * Class AdminService
 * @package App\Player\Service
 */
class PlayerService
{
    use Queryable;

    /**
     * AdminService constructor.
     * @param PlayerMapper $mapper
     */
    public function __construct(PlayerMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param $email
     * @param $password
     * @return Player|null
     */
    public function findByEmailAndPassword($email, $password)
    {
        return $this->mapper->findByEmailAndPassword($email, $password);
    }

    /**
     * @param $email
     * @return Player|null
     */
    public function findByEmail($email)
    {
        return $this->mapper->findByEmail($email);
    }
}