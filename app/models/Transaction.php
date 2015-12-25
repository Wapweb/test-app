<?php
/**
 * Created by PhpStorm.
 * User: Шаповал
 * Date: 25.12.2015
 * Time: 17:16
 */

namespace TestApp\Models;

use Phalcon\Mvc\Model;

class Transaction extends Model {
    /**
     * @var int $_id
     */
    private $_id;

    /**
     * @var int $_senderId
     */
    private $_senderId;

    /**
     * @var int $_recipientId
     */
    private $_recipientId;

    /**
     * @var  int $_creationTime
     */
    private $_creationTime;

    /**
     * @var int $_amount
     */
    private $_amount;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * @return int
     */
    public function getCreationTime()
    {
        return $this->_creationTime;
    }

    /**
     * @param int $creationTime
     */
    public function setCreationTime($creationTime)
    {
        $this->_creationTime = $creationTime;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return int
     */
    public function getRecipientId()
    {
        return $this->_recipientId;
    }

    /**
     * @param int $recipientId
     */
    public function setRecipientId($recipientId)
    {
        $this->_recipientId = $recipientId;
    }

    /**
     * @return int
     */
    public function getSenderId()
    {
        return $this->_senderId;
    }

    /**
     * @param int $senderId
     */
    public function setSenderId($senderId)
    {
        $this->_senderId = $senderId;
    }



    public function beforeValidationOnCreate()
    {
        $this->setCreationTime(date('Y-m-d H:i:s', time()));
    }

    public function getSource()
    {
        return 'transaction';
    }

    public function columnMap()
    {
        return [
            'transaction_id' => '_id',
            'sender_id' => '_senderId',
            'recipient_id' => '_recipientId',
            'transaction_datetime' => '_creationTime',
            'transaction_amount' => '_amount'
        ];
    }


} 