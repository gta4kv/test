<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 28/08/2017
 * Time: 01:19
 */

namespace App\Trade;


use Useless\Database\MappableObject;
use Useless\Database\Mapper;

/**
 * Class TradeMapper
 * @package App\Trade
 */
class TradeMapper extends Mapper
{
    /**
     * @var string
     */
    protected $tableName = 'trades';

    /**
     * @var array
     */
    protected $fields = [
        'id', 'offer_id', 'player_id', 'partner_id', 'amount_fiat', 'amount_bitcoin', 'status', 'created_at'
    ];

    /**
     * @param integer $playerId
     * @return Trade[]
     */
    public function findByPlayerOrPartner($playerId)
    {
        $sql = 'SELECT ' . implode(', ', $this->fields) . ' FROM trades WHERE player_id = :playerId OR partner_id = :playerId';

        $query = $this->database->queryPrepared($sql, [
            'playerId' => $playerId
        ]);

        $output = [];
        foreach ($query->all() as $result) {
            $output[] = $this->mapObject($result);
        }

        return $output;
    }

    /**
     * @param $object
     * @return MappableObject|Trade
     */
    protected function mapObject($object)
    {
        return (new Trade())
            ->setId($object['id'])
            ->setPlayerId($object['player_id'])
            ->setPartnerId($object['partner_id'])
            ->setOfferId($object['offer_id'])
            ->setAmountFiat($object['amount_fiat'])
            ->setAmountBitcoin($object['amount_bitcoin'])
            ->setCreatedAt($object['created_at'])
            ->setStatus($object['status']);
    }

    /**
     * @param MappableObject|Trade $object
     */
    public function create(MappableObject $object)
    {
        // hack hack
        unset($this->fields[6]);
        unset($this->fields[7]);

        $sql = "INSERT INTO trades (" . implode(', ', $this->fields) . ") VALUES (NULL, :offerId, :playerId, :partnerId, :amountFiat, :amountBitcoin)";

        $this->database->queryPrepared($sql, [
            'offerId'       => $object->getOfferId(),
            'playerId'      => $object->getPlayerId(),
            'partnerId'     => $object->getPartnerId(),
            'amountFiat'    => $object->getAmountFiat(),
            'amountBitcoin' => $object->getAmountBitcoin()
        ]);
    }

    /**
     * @param MappableObject|Trade $object
     */
    public function update(MappableObject $object)
    {
        unset($this->fields[7]);

        $sql = "UPDATE trades SET id = :id, offer_id = :offerId, player_id = :playerId, partner_id = :partnerId, amount_fiat = :amountFiat, 
          amount_bitcoin = :amountBitcoin, status = :status WHERE id = :id";

        $this->database->queryPrepared($sql, [
            'id'            => $object->getId(),
            'offerId'       => $object->getOfferId(),
            'playerId'      => $object->getPlayerId(),
            'partnerId'     => $object->getPartnerId(),
            'amountFiat'    => $object->getAmountFiat(),
            'amountBitcoin' => $object->getAmountBitcoin(),
            'status'        => $object->getStatus(),
            'createdAt'     => $object->getCreatedAt()
        ]);
    }
}