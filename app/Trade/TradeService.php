<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 28/08/2017
 * Time: 01:36
 */

namespace App\Trade;


use App\Offers\Offer;
use Useless\Database\Queryable;
use Useless\Validator\Validator;

/**
 * Class TradeService
 * @package App\Trade
 */
class TradeService
{
    use Queryable;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * TradeService constructor.
     * @param TradeMapper $mapper
     * @param Validator $validator
     */
    public function __construct(TradeMapper $mapper, Validator $validator)
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

    /**
     * @param integer $playerId
     * @return Trade[]
     */
    public function findByPlayerOrPartner($playerId)
    {
        return $this->mapper->findByPlayerOrPartner($playerId);
    }

    /**
     * @param array $values
     * @param Offer $offer
     * @return Validator
     */
    public function validate(array $values, Offer $offer)
    {
        $validator = $this->validator->setRules([
            ['tradeType', [
                ['in', ['values' => [1, 0]]]
            ]],
            ['amount', [
                ['required'],
                ['numeric', ['min' => $offer->getMin(), 'max' => $offer->getMax()]]
            ]]
        ])->setFieldTranslations([
            'amount'    => 'Amount',
            'tradeType' => 'Trade type'
        ]);

        $validator->validate($values);

        return $validator;
    }
}