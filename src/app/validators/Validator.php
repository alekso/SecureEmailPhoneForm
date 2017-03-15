<?php


namespace app\validators;


abstract class Validator {

    protected $error_message;

    abstract function validate();

    public function getValidationError()
    {
        return (isset($this->error_message))? $this->error_message : null;
    }
}