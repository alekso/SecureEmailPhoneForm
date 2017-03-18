<?php
namespace app;

use app\Contact\Repository\ContactRepository;
use app\Contact\SecureContact;
use app\encryption\McryptEncryption;

Container::bind('contact', function ($email){
    return New SecureContact ( $email,
        new McryptEncryption(),
        new ContactRepository( DB::connect( Config::get('database') ) )
    );
});