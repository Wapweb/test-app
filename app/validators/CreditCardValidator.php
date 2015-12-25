<?php
namespace TestApp\Validators;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;

class CreditCardValidator  extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        $cardNumber = $model->$field;

        $cardLength = strlen($cardNumber);

        if($cardLength < 15 || $cardLength > 16) {
            $this->appendMessage(
                "Invalid credit card number: must be 15 or 16 digits",
                $field,
                "CreditCardValidator"
            );

            return false;
        }


        $isValidCreditCardNumber = $this->_checkCreditCardNumber($cardNumber);

        if($isValidCreditCardNumber === false)
        {
            $this->appendMessage(
                "Invalid credit card number",
                $field,
                "CreditCardValidator"
            );

            return false;
        }

        return true;
    }

    private function _checkCreditCardNumber($cardNumber)
    {
        switch($cardNumber) {
            case(preg_match ('/^4/', $cardNumber) >= 1):
                return 'Visa';
            case(preg_match ('/^5[1-5]/', $cardNumber) >= 1):
                return 'Mastercard';
            case(preg_match ('/^3[47]/', $cardNumber) >= 1):
                return 'Amex';
            case(preg_match ('/^3(?:0[0-5]|[68])/', $cardNumber) >= 1):
                return 'Diners Club';
            case(preg_match ('/^6(?:011|5)/', $cardNumber) >= 1):
                return 'Discover';
            case(preg_match ('/^(?:2131|1800|35\d{3})/', $cardNumber) >= 1):
                return 'JCB';
            default:
                return false;
                break;
        }
    }
} 