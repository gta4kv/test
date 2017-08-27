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
use Useless\Validator\Validator;

/**
 * Class AdminService
 * @package App\Player\Service
 */
class PlayerService
{
    use Queryable;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * AdminService constructor.
     * @param PlayerMapper $mapper
     * @param Validator $validator
     */
    public function __construct(PlayerMapper $mapper, Validator $validator)
    {
        $this->mapper = $mapper;

        $this->validator = $validator;
    }

    /**
     * @param array $values
     * @return Validator
     */
    public function validate(array $values)
    {
        $validator = $this->validator->setRules([
            ['password', [
                ['required'],
            ]],
            ['full_name', [
                ['required'],
                ['length', ['max' => 60]]
            ]],
            ['email', [
                ['required'],
                ['email'],
                ['length', ['max' => 200]],
                ['closure', ['function' => function () use ($values) {
                    if ($this->findByEmail($values['email'])) {
                        return ' is already in use by other user';
                    }

                    return true;
                }]]
            ]],
        ])
            ->setFieldTranslations([
                'password'  => 'Password',
                'full_name' => 'Full Name',
                'email'     => 'Email'
            ]);

        $validator->validate($values);

        return $validator;
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

    public function findByUsername($username)
    {
        $this->setField('username')
            ->setOperator('=')
            ->setValue($username);

        return $this->find();
    }

    /**
     * @param $email
     * @return \Useless\Database\MappableObject|\Useless\Database\MappableObject[]
     */
    public function findByEmail($email)
    {
        $this->setField('email')
            ->setOperator('=')
            ->setValue($email);

        return $this->find();
    }
}