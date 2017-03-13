<?php
namespace app\validators;

interface IValidator {
    public function validate();
    public function getValidationError();
}