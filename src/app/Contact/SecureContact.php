<?php

namespace app\Contact;

use app\Contact\Repository\ContactRepository;
use app\encryption\IEncryption;

/**
 * Contact class file.
 *
 */
class SecureContact
{

    use EmailTrait;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var IEncryption
     */
    private $encryptor;

    /**
     * @var \PDO
     */
    private $repository;


    /**
     * Contact constructor.
     * @param IEncryption $encryptor
     * @param ContactRepository $repository
     * @internal param \PDO $connection
     */
    public function __construct(IEncryption $encryptor, ContactRepository $repository)
    {
        $this->encryptor = $encryptor;
        $this->repository = $repository;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string | boolean
     */
    public function getPhone()
    {
        if (isset($this->phone))
        {
            return $this->phone;
        }

        $_email=$this->getEmailHash();
        $record=$this->repository->getRecordByEmail($_email);

        if ($record) 
        {
            return $this->decrypt($record["phone"]);
        }

        return false;
    }

    /**
     * @return string
     */
    public function getEmailHash()
    {
        return $this->encryptor->hash($this->email);
    }

    /**
     * @return int
     */
    public function encrypt()
    {
        if (!empty($this->phone)&&!empty($this->phone))
        {
            return $this->encryptor->encrypt($this->phone, $this->email);
        }

        return null;
    }

    /**
     * @param $phone_hash
     * @return mixed
     */
    protected function decrypt($phone_hash)
    {
        return $this->encryptor->decrypt($phone_hash, $this->email);
    }

    /**
     *@return void
     */
    public function createSecure()
    {
        $_email=$this->getEmailHash();
        $_phone=$this->encrypt();
        $this->repository->save($_email, $_phone);
    }

    /**
     * @return mixed
     */
    public function retrievePhone()
    {
        $phone=$this->getPhone();

        if ($phone)
        {
            $subject="Your phone number";
            $message="Hi there,\n This email was sent from ".$_SERVER['HTTP_HOST'].". Your phone number is ".$phone;

            $this->sendEmail($this->getEmail(), $subject, $message);

            return true;
        }

        echo "Phone number for this email not found in the database."."<br />";
        exit();
    }
}