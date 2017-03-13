<?php
/**
 * Server.php - script to create secure user contact and retrieve phone on email forms
 * @uses string $_POST["email"]
 * @uses string $_POST["phone"]
 * @uses string $_POST["retrieve_email"]
 * @package  Test Task 001
 * @author   Aleko Apostolidis 
 */
namespace app;
// mute errors
error_reporting(0);
ini_set( "display_errors", "0" );

//include database config file
require_once "app/config.php";

//register classes
spl_autoload_register(
    function ($class) {
        $class_pieces=explode("\\", $class);
        include  __DIR__.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $class_pieces). '.php';
});

use app\Contact\Contact;
use app\encryption\McryptEncryption;
use app\validators\EmailValidator;
use app\validators\PhoneValidator;


// user email and phone registration FORM
 if(isset($_POST["email"]) && isset($_POST['phone'])) {
    $emailValidator = New EmailValidator($_POST["email"]);
    $email=$emailValidator->validate();
    $phoneValidator = New PhoneValidator($_POST["phone"]);
    $phone=$phoneValidator->validate();
    // validate email and phone
    if ($email&&$phone){
        $contact = New Contact($email, new McryptEncryption(), DB::connect());
        $contact->setPhone($phone);
        $contact->createSecure();
        // generate simple response to infort that record created and exit
        echo Helpers::getAddSuccessHtml();
        exit();
    }
    Helpers::setCookieError("email", $emailValidator->getValidationError());
}


// User retrieve phone on email FORM
if (isset($_POST["retrieve_email"])) {
    $emailValidator = New EmailValidator($_POST["retrieve_email"]);
    $email=$emailValidator->validate();
    //validate email
    if ($email){
        $contact = New Contact($email, new McryptEncryption(), DB::connect());
        $contact->retrievePhone();
        //generate html response
        echo Helpers::getRetrieveSuccessHtml($email);
        exit();
    }
    Helpers::setCookieError("retrieve_email", $emailValidator->getValidationError());
}


// make redirect
Helpers::redirect();

