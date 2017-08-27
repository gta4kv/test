<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/08/2017
 * Time: 19:29
 */

namespace App\Offers;


use App\Currency\Currency;
use App\Payment\Method;
use App\Payment\Method\Group;
use Useless\Database\MappableObject;
use Useless\Database\Queryable;
use Useless\Validator\Validator;

/**
 * Class OfferService
 * @package App\Offers
 */
class OfferService
{
    use Queryable;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * OfferService constructor.
     * @param OfferMapper $mapper
     * @param Validator $validator
     */
    public function __construct(OfferMapper $mapper, Validator $validator)
    {
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    public function findAllByPlayerId($playerId)
    {
        $this
            ->setOperator('=')
            ->setField('player_id')
            ->setValue($playerId);

        return $this->find(false);
    }

    public function findAllEnabled()
    {
        $this
            ->setOperator('=')
            ->setField('disabled')
            ->setValue(0);

        return $this->find(false);
    }

    /**
     * @param array $values
     * @param MappableObject[]|Currency[] $currencies
     * @param MappableObject|Group[] $pmGroups
     * @param MappableObject|Method[] $paymentMethods
     * @return Validator
     */
    public function validate(array $values, $currencies, $pmGroups, $paymentMethods)
    {
        $validator = $this->validator->setRules([
            ['tradeType', [
                ['in', ['values' => [1, 0]]]
            ]],
            ['currencyId', [
                ['required'],
                ['in', ['values' => $currencies, 'isObject' => true, 'function' => 'getId']]
            ]],
            ['paymentMethodGroup', [
                ['required'],
                ['in', ['values' => $pmGroups, 'isObject' => true, 'function' => 'getId']]
            ]],
            ['paymentMethod', [
                ['required'],
                ['in', ['values' => $paymentMethods, 'isObject' => true, 'function' => 'getId']],
                ['closure', ['function' => function ($value) use ($values, $paymentMethods) {
                    foreach ($paymentMethods as $method) {
                        if ($value == $method->getId()) {
                            if ($method->getGroupId() != $values['paymentMethodGroup']) {
                                return ' does not belong to selected payment group, you dirty hacker!';
                            }
                        }
                    }

                    return true;
                }]]
            ]],
            ['amountMin', [
                ['required'],
                ['numeric', ['min' => 0.1, 'max' => 10000]]
            ]],
            ['amountMax', [
                ['required'],
                ['numeric', ['min' => 0.1, 'max' => 10000]]
            ]],
            ['margin', [
                ['required'],
                ['numeric', ['min' => 0.1, 'max' => 1000]]
            ]]
        ])->setFieldTranslations([
            'tradeType'          => 'Trade type',
            'currencyId'         => 'Currency',
            'paymentMethodGroup' => 'PM Group',
            'paymentMethod'      => 'PM',
            'amountMin'          => 'Amount Min',
            'amountMax'          => 'Amount Max',
            'margin'             => 'Margin'
        ]);

        $validator->validate($values);

        return $validator;
    }
}