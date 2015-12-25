<?php

namespace TestApp\Library;

use TestApp\Models\User;

class SendMoneyBetweenUsers implements ISendMoney {
    /**
     * @var User $_recipient
     */
    private $_recipient;

    /**
     * @var User $_recipient
     */
    private $_sender;
    
    /** @var  double $_amount */
    private $_amount;

    /**
     * @var array
     */
    private $_errors = [];
    
    public function __construct(User $sender, User $recipient, $amount) {
        $this->_recipient = $recipient;
        $this->_sender = $sender;
        $this->_amount = $amount;
    }
    
    public function process()
    {
        if ($this->_amount > 0 && $this->_sender && $this->_recipient) {
            if ($this->_sender->getId() != $this->_recipient->getId()) {
                $senderCardAmount = $this->_sender->getCardAmount();
                $recipientCardAmount = $this->_recipient->getCardAmount();

                if ($senderCardAmount >= $this->_amount)
                {
                    $this->_sender->setCardAmount($senderCardAmount - $this->_amount);
                    $this->_recipient->setCardAmount($recipientCardAmount + $this->_amount);

                    $result = ($this->_sender->save() && $this->_recipient->save());

                    if ($result === false)
                    {
                        foreach (array_merge($this->_sender->getMessages(), $this->_recipient->getMessages()) as $message)
                            $this->_addError($message->getMessage());
                    }

                    return true;

                }
                else
                {
                    $this->_addError("sender amount must be less than sender card amount");
                }
            }
            else
            {
                $this->_addError("sender and recipient cannot be equal");
            }
        }
        else
        {
            $this->_addError("invalid amount or/and recipient or sender");
        }

        return false;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    private function _addError($errorMessage)
    {
        $this->_errors[] = $errorMessage;
    }

} 