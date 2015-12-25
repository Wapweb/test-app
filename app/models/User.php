<?php

namespace TestApp\Models;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Numericality;
use TestApp\Validators\NumericRangeValidator;
use TestApp\Validators\CreditCardValidator;

class User extends Model
{
    /**
     * @var int $_id
     */
    private $_id;

    /**
     * @var int $_cardNumber
     */
    private $_cardNumber;

    /**
     * @var int $_cardCv2
     */
    private $_cardCv2;

    /**
     * @var string $_cardExpirationDate
     */
    private $_cardExpirationDate;

    /**
     * @var string $_cardHoldName
     */
    private $_cardHoldName;

    /**
     * @var string $_email
     */
    private $_email;

    /**
     * @var string $_firstName
     */
    private $_firstName;

    /**
     * @var string $_lastName
     */
    private $_lastName;

    /**
     * @var float $_cardAmount
     */
    private $_cardAmount;

    /**
     * @var array
     */
    private $_errors = [];

    /**
     * @return float
     */
    public function getCardAmount()
    {
        return $this->_cardAmount;
    }

    /**
     * @param float $cardAmount
     */
    public function setCardAmount($cardAmount)
    {
        $this->_cardAmount = $cardAmount;
    }

    /**
     * @return int
     */
    public function getCardCv2()
    {
        return $this->_cardCv2;
    }

    /**
     * @param int $cardCv2
     */
    public function setCardCv2($cardCv2)
    {
        $this->_cardCv2 = $cardCv2;
    }

    /**
     * @return string
     */
    public function getCardExpirationDate()
    {
        return $this->_cardExpirationDate;
    }

    /**
     * @param string $cardExpirationDate
     */
    public function setCardExpirationDate($cardExpirationDate)
    {
        $this->_cardExpirationDate = $cardExpirationDate;
    }

    /**
     * @return string
     */
    public function getCardHoldName()
    {
        return $this->_cardHoldName;
    }

    /**
     * @param string $cardHoldName
     */
    public function setCardHoldName($cardHoldName)
    {
        $this->_cardHoldName = $cardHoldName;
    }

    /**
     * @return int
     */
    public function getCardNumber()
    {
        return $this->_cardNumber;
    }

    /**
     * @param int $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->_cardNumber = $cardNumber;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->_firstName . " " . $this->_lastName;
    }
    
    public function sendMoney($amount, User $recipient, Transaction $transaction)
    {
        if ($amount > 0 && $recipient) {
            if ($this->getId() != $recipient->getId()) {
                $senderCardAmount = $this->getCardAmount();
                $recipientCardAmount = $recipient->getCardAmount();

                if ($senderCardAmount >= $amount)
                {
                    $this->setCardAmount($senderCardAmount - $amount);
                    $recipient->setCardAmount($recipientCardAmount + $amount);

                    /** @var \Phalcon\Db\Adapter\Pdo\Mysql $db */
                    $db = $this->getDI()->get("db");

                    $db->begin();

                    $result = ($this->save() && $recipient->save());

                    if ($result === false)
                    {
                        foreach (array_merge($this->getMessages(), $recipient->getMessages()) as $message)
                            $this->_addError($message->getMessage());

                        $db->rollback();
                    }

                    $transaction->setAmount($amount);
                    $transaction->setRecipientId($recipient->getId());
                    $transaction->setSenderId($this->getId());

                    if($transaction->save() === false) {
                        foreach ($transaction->getMessages() as $message)
                            $this->_addError($message->getMessage());

                        $db->rollback();
                    }


                    $db->commit();

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

    public function validation()
    {
        $this->validate(
            new Email(
                [
                    'field' => "_email",
                    'message' => "Invalid email"
                ]
            )
        );

        $this->validate(new StringLength([
            'field' => '_cardHoldName',
            'max' => 255,
            'min' => 2,
            'messageMaximum' => 'Card Hold Name length must be at least 2 character and less than 255 characters',
            'messageMinimum' => 'Card Hold Name length must be at least 2 character and less than 255 characters'
        ]));

        $this->validate(new StringLength([
            'field' => '_lastName',
            'max' => 100,
            'min' => 2,
            'messageMaximum' => 'Last Name length must be at least 2 character and less than 100 characters',
            'messageMinimum' => 'Last Name length must be at least 2 character and less than 100 characters'
        ]));

        $this->validate(new StringLength([
            'field' => '_firstName',
            'max' => 100,
            'min' => 2,
            'messageMaximum' => 'First Name length must be at least 2 character and less than 100 characters',
            'messageMinimum' => 'First Name length must be at least 2 character and less than 100 characters'
        ]));

        $this->validate(
            new Numericality(
                [
                    'field' => '_cardNumber'
                ]
            )
        );

        $this->validate(
            new Numericality(
                [
                    'field' => '_cardCv2'
                ]
            )
        );

        $this->validate(
            new NumericRangeValidator(
                [
                    'field' => "_cardCv2",
                    'max' => 3,
                    'min' => 3
                ]
            )
        );

        $this->validate(
            new CreditCardValidator(
                [
                    'field' => "_cardNumber"
                ]
            )
        );

        return $this->validationHasFailed() != true;
    }

    public function getSource()
    {
        return 'user';
    }

    public function columnMap()
    {
        return [
            'user_id' => '_id',
            'card_number' => '_cardNumber',
            'card_cv2' => '_cardCv2',
            'card_expiration_date' => '_cardExpirationDate',
            'card_hold_name' => '_cardHoldName',
            'user_email' => '_email',
            'user_first_name' => '_firstName',
            'user_last_name' => '_lastName',
            'card_amount' => '_cardAmount'
        ];
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}