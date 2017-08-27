<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/08/2017
 * Time: 15:38
 */

namespace App\Offers;

use Useless\Database\MappableObject;
use Useless\Database\Mapper;

class OfferMapper extends Mapper
{
    /**
     * @var array
     */
    protected $fields = ['id', 'player_id', 'type', 'payment_method_id', 'currency_id', 'amount_min', 'amount_max', 'margin', 'disabled'];

    /**
     * @var string
     */
    protected $tableName = 'offers';

    public function delete($id)
    {
        $sql = 'DELETE FROM offers WHERE id = :id';

        $this->database->queryPrepared($sql, [
            'id' => $id
        ]);
    }

    /**
     * @param MappableObject|Offer $offer
     * @return bool
     */
    public function create(MappableObject $offer)
    {
        $sql = "INSERT INTO offers (" . implode(', ', $this->fields) . ") VALUES (NULL, :playerId, :type, :paymentMethodId, :currencyId, :amountMin, :amountMax, :margin, :disabled)";

        $this->database->queryPrepared($sql, [
            'playerId'        => $offer->getPlayerId(),
            'type'            => $offer->getType(),
            'paymentMethodId' => $offer->getPaymentMethodId(),
            'currencyId'      => $offer->getCurrencyId(),
            'amountMin'       => $offer->getMin(),
            'amountMax'       => $offer->getMax(),
            'margin'          => $offer->getMargin(),
            'disabled'        => $offer->isDisabled()
        ]);

        return true;
    }

    /**
     * @param Offer|MappableObject $offer
     * @return bool
     */
    public function update(MappableObject $offer)
    {
        $sql = "UPDATE offers SET player_id = :playerId, type = :type, payment_method_id = :paymentMethodId, currency_id = :currencyId, amount_min = :amountMin, amount_max = :amountMax, margin = :margin, disabled = :disabled WHERE id = :id";

        $this->database->queryPrepared($sql, [
            'id'              => $offer->getId(),
            'playerId'        => $offer->getPlayerId(),
            'type'            => $offer->getType(),
            'paymentMethodId' => $offer->getPaymentMethodId(),
            'currencyId'      => $offer->getCurrencyId(),
            'amountMin'       => $offer->getMin(),
            'amountMax'       => $offer->getMax(),
            'margin'          => $offer->getMargin(),
            'disabled'        => $offer->isDisabled()
        ]);

        return true;
    }

    /**
     * @param $object
     * @return MappableObject
     */
    protected function mapObject($object)
    {
        return (new Offer())
            ->setId($object['id'])
            ->setPlayerId($object['player_id'])
            ->setType($object['type'])
            ->setPaymentMethodId($object['payment_method_id'])
            ->setCurrencyId($object['currency_id'])
            ->setMin($object['amount_min'])
            ->setMax($object['amount_max'])
            ->setMargin($object['margin'])
            ->setDisabled($object['disabled']);
    }
}