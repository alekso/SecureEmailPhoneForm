<?php
/**
 * Server.php - script to create secure user contact and retrieve phone on email forms
 * @package  Test Task 001
 * @author   Aleko Apostolidis
 */
namespace app;
// mute errors
error_reporting(0);
ini_set( "display_errors", "0" );

//include database config file
require_once "app/config.php";

classesAutoloader();

use app\Contact\Contact;
use app\encryption\McryptEncryption;
use app\validators;

if (isset($_POST['email']) && isset($_POST['phone']))
{
    $email=validate(New validators\EmailValidator($_POST['email']));
    $phone=validate(New validators\PhoneValidator($_POST['phone']));

    if ($email === true && $phone === true)
    {
        $contact = New Contact($email, new McryptEncryption(), DB::connect());
        $contact->setPhone($phone);
        $contact->createSecure();
        // generate simple response to inform that record created and exit
        echo Helpers::getAddSuccessHtml();
        exit();
    }
    Helpers::setCookieError("email", $email);
}

if (isset($_POST['retrieve_email']))
{
    $email=validate(New validators\EmailValidator($_POST['retrieve_email']));
    if ($email===true)
    {
        $contact = New Contact($email, new McryptEncryption(), DB::connect());
        $contact->retrievePhone();
        //generate html response
        echo Helpers::getRetrieveSuccessHtml($email);
        exit();
    }

    Helpers::setCookieError("retrieve_email", $email);
}


// make redirect
Helpers::redirect();

/**
 * @var validators\Validator $validator
 * @return true|string
 */

function validate(validators\Validator $validator)
{
    if ($validator->validate())
    {
        return true;
    }
    return $validator->getValidationError();
}

/**
 * @return void
 */
function classesAutoloader()
{
    spl_autoload_register(
        function ($class) {
            $class_pieces=explode("\\", $class);
            include  __DIR__.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $class_pieces). '.php';
        });
}