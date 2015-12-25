<?php
namespace TestApp\Validators;

use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\ValidatorInterface;
use Phalcon\Mvc\EntityInterface;

class NumericRangeValidator extends Validator implements ValidatorInterface
{
    public function validate(EntityInterface $model)
    {
        $field = $this->getOption('field');

        $min   = $this->getOption('min');
        $max   = $this->getOption('max');

        $value = $model->$field;

        if ($min <= $value && $value <= $max) {
            $this->appendMessage(
                "The field doesn't have the right range of values",
                $field,
                "NumericRangeValidator"
            );

            return false;
        }

        return true;
    }
} 