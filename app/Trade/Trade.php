<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 27/08/2017
 * Time: 23:24
 */

namespace App\Trade;


use Useless\Database\MappableObject;

/**
 * Class Trade
 * @package App\Trade
 */
class Trade implements MappableObject
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $offerId;

    /**
     * @var int
     */
    private $playerId;

    /**
     * @var int
     */
    private $partnerId;

    /**
     * @var float
     */
    private $amountFiat;

    /**
     * @var float
     */
    private $amountBitcoin;

    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var string
     */
    private $status;

    /**
     * @return int
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * @param int $offerId
     * @return $this
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * @param int $playerId
     * @return $this
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @param int $partnerId
     * @return $this
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmountFiat()
    {
        return $this->amountFiat;
    }

    /**
     * @param float $amountFiat
     * @return $this
     */
    public function setAmountFiat($amountFiat)
    {
        $this->amountFiat = $amountFiat;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmountBitcoin()
    {
        return $this->amountBitcoin;
    }

    /**
     * @param float $amountBitcoin
     * @return $this
     */
    public function setAmountBitcoin($amountBitcoin)
    {
        $this->amountBitcoin = $amountBitcoin;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNewRecord()
    {
        return $this->getId() === null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}