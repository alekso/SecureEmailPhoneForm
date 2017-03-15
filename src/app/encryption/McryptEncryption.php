<?php

namespace app\encryption;

/**
 * Class McryptEncryption
 * @package app\encryption
 */
class McryptEncryption implements IEncryption
{

    /**
     * @var array
     * static salt used in email hash method to have same hash for same email in database
     */
    private $options=array();

    public function __construct()
    {
        $this->options=$this->staticSalt();
    }

    public function hash($string)
    {
        return @password_hash($string, PASSWORD_DEFAULT, $this->options);
    }

    public function encrypt($string, $key)
    {
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    }

    public function decrypt($string, $key)
    {
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }

    private function staticSalt()
    {
       return array(
            'cost' => 11,
            'salt' =>base64_encode("ThisIsVerySecureSaltHashString"),
        );
    }
}