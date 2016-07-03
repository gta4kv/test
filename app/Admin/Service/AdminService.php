<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 03/07/16
 * Time: 22:22
 */

namespace App\Admin\Service;


use App\Admin\Mapper\AdminMapper;

/**
 * Class AdminService
 * @package App\Admin\Service
 */
class AdminService
{
    /**
     * @var AdminMapper
     */
    protected $mapper;

    /**
     * AdminService constructor.
     * @param AdminMapper $mapper
     */
    public function __construct(AdminMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param $email
     * @param $password
     * @return \App\Admin\Admin|null
     */
    public function findByEmailAndPassword($email, $password)
    {
        return $this->mapper->findByEmailAndPassword($email, $password);
    }

    /**
     * @param $email
     * @return \App\Admin\Admin|null
     */
    public function findByEmail($email)
    {
        return $this->mapper->findByEmail($email);
    }
}