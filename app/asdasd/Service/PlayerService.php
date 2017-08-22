<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:31
 */

namespace App\Player\Service;

use App\Player\Player;
use useless\Database\MappableObject;
use useless\Database\Queryable;

/**
 * Class PlayerService
 * @package App\Player\Service
 */
class PlayerService
{
    use Queryable;

    /**
     * @param $username
     * @return MappableObject|Player
     */
    public function findByUsername($username)
    {
        $this->setField('username')
            ->setOperator('=')
            ->setValue($username);

        return $this->find();
    }
}