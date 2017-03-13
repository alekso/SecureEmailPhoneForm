<?php
namespace app\validators;

class PhoneValidator implements IValidator{

    private $phone;

    public $error_message;

    /**
     * PhoneValidator constructor.
     * @param $phone
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return bool|mixed
     */
    public function validate()
    {
        $validation=false;
        //no validation required by test task so we just sanitize the phone string as temp solution
        //{TODO}implement phone validation https://github.com/giggsey/libphonenumber-for-php (Google phone validation library)
        if (!empty($this->phone)){
            $validation= filter_var($this->phone, FILTER_SANITIZE_NUMBER_INT);
         }
        return $validation;
    }

    /**
     * @return string|null
     */
    public function getValidationError()
    {
        return (isset($this->error_message))? $this->error_message : null;
    }
}