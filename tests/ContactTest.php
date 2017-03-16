<?php
namespace Test;

require_once __DIR__.'/../src/app/config.php';

use app\Contact\Repository\ContactRepository;
use PHPUnit\Framework\TestCase;
use \app\Contact\SecureContact;
use \app\encryption\McryptEncryption;
use \app\DB;

class ContactTest extends TestCase
{

    private $contact;

    protected function setUp()
    {
        $this->contact = New SecureContact("test@test.com", new McryptEncryption(), new ContactRepository(DB::connect()));
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
