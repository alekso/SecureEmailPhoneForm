<?php
/**
 * Server.php - script to create secure user contact and retrieve phone on email forms
 * @package  Test Task 001
 * @author   Aleko Apostolidis
 */
namespace app;

// mute errors
error_reporting(1);
ini_set( "display_errors", "1" );

//include database config file
//require_once "app/config.php";

classAutoloader();



use app\validators\EmailValidator;
use app\validators\PhoneValidator;

// DI Container bindings
require_once "app/bindings.php";
// Loading config file
Config::load("../src/app.config.json");

if ( isset($_POST['email']) && isset($_POST['phone']) )
{
    $emailValidator = New EmailValidator($_POST['email']);
    $email = $emailValidator->validate();

    $phoneValidator = New PhoneValidator($_POST['phone']);
    $phone = $phoneValidator->validate();

    if ($email && $phone)
    {
        $contact = Container::make('contact', $email);
        $contact->setPhone($phone);
        $contact->createSecure();
        // generate simple response to inform that record created and exit
        echo Helpers::getAddSuccessHtml();
        exit();
    }

    Helpers::setCookieError("email", $emailValidator->getValidationError());
}

if (isset($_POST['retrieve_email']))
{
    $emailValidator = New EmailValidator($_POST['retrieve_email']);
    $email = $emailValidator->validate();

    if ($email)
    {
        $contact = Container::make('contact', $email);
        $contact->retrievePhone();
        //generate html response
        echo Helpers::getRetrieveSuccessHtml($email);
        exit();
    }

    Helpers::setCookieError("retrieve_email", $emailValidator->getValidationError());
}

// make redirect
Helpers::redirect();
exit();

function classAutoloader ()
{
    spl_autoload_register (
        function ($class) {
            $class_pieces=explode("\\", $class);
            include  __DIR__.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $class_pieces). '.php';
        });
}