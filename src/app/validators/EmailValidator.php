<?php
namespace app\validators;

class EmailValidator implements IValidator{
    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    public $error_message;

    /**
     * EmailValidator constructor.
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
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

    /**
     * @return string | null
     */
    public function getValidationError(){
        return (isset($this->error_message))? $this->error_message : null;
    }
}