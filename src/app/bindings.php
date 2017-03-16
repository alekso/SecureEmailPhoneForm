<?php
namespace app;

use app\Contact\Repository\ContactRepository;
use app\Contact\SecureContact;
use app\encryption\McryptEncryption;

Container::bind('contact', function (){
    return New SecureContact(new McryptEncryption(), new ContactRepository(DB::connect()));
});