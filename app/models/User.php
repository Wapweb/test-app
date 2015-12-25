<?php

namespace TestApp\Models;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Numericality;
use TestApp\Validators\NumericRangeValidator;


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
     * @var int $_cardHoldNumber
     */
    private $_cardHoldNumber;

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
     * @return int
     */
    public function getCardHoldNumber()
    {
        return $this->_cardHoldNumber;
    }

    /**
     * @param int $cardHoldNumber
     */
    public function setCardHoldNumber($cardHoldNumber)
    {
        $this->_cardHoldNumber = $cardHoldNumber;
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

        $this->validate(
            new Uniqueness(
                [
                    'field' => "_email",
                    'message' => "This email is already present in another user record"
                ]
            )
        );

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
            new Numericality(
                [
                    'field' => '_cardHoldNumber'
                ]
            )
        );

        $this->validate(
            new NumericRangeValidator(
                [
                    'field' => "_cardNumber",
                    'max' => 16,
                    'min' => 16
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
            'card_hold_number' => '_cardHoldNumber',
            'user_email' => '_email',
            'user_first_name' => '_firstName',
            'user_last_name' => '_lastName',
            'card_amount' => '_cardAmount'
        ];
    }
} 