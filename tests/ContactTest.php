<?php
require_once "../src/app/config.php";
require_once  '../src/app/Contact/Contact.php';
require_once  '../src/app/encryption/IEncryption.php';
require_once  '../src/app/encryption/McryptEncryption.php';
require_once '../src/app/DB.php';
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/27/2016
 * Time: 6:07 PM
 */
class ContactTest extends PHPUnit_Framework_TestCase
{

    private $contact;

    protected function setUp()
    {
        $this->contact = New \app\Contact\Contact("test@test.com", new \app\encryption\McryptEncryption(), \app\DB::connect());
    }

    function testItCanReadEmail()
    {
        $email=$this->contact->getEmail();
        $this->assertEquals("test@test.com", $email);
    }

    function testItCanMakeEmailHash()
    {
        $emailHash=$this->contact->getEmailHash();
        $hashString='$2y$11$VGhpc0lzVmVyeVNlY3VyZORSxeYYTIC8GtgEC8Yubx/x6ctx899rS';
        $this->assertEquals($hashString, $emailHash);
    }

    function testItCanReadAndSavePhone()
    {
        $this->contact->setPhone("+38978999999");
        $this->assertEquals("+38978999999", $this->contact->getPhone());
    }

    function testItCanEncryptPhoneNumber()
    {
        $this->contact->setPhone("+38978999999");
        $this->assertEquals('YXw6zXzQBuNE6XwYj16tH9YmH5jjqNdGbPmRsk0vT74=', $this->contact->encrypt());
    }
}
