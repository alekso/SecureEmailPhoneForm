<?php
namespace app\validators;

class EmailValidator extends Validator
{

    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the validator email, or FALSE if the validator fails.
     * @return string|false
     */
    public function validate()
    {
        $validation=filter_var($this->email, FILTER_VALIDATE_EMAIL);
        if (!$validation){
            $this->error_message="Email is not correct";
        }
        return $validation;
    }
}