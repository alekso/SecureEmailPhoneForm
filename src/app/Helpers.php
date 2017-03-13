<?php
namespace app;

/**
 * Class Helpers methods
 * @package app
 */
class Helpers {

    /**
     * Redirect browser and stop further execution
     * @return null
     */
    public static function redirect(){
        $url=$_SERVER['HTTP_HOST'];
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
            $url=$_SERVER['HTTP_REFERER'];
        header("Location: ".$url);
        exit();
    }

    public static function getAddSuccessHtml(){
        $url="../index.php";
        return <<<EOT
<h3>You phone number was successfully added.</h3>
Please click <a href='{$url}'>here</a> to return to form page.

EOT;
    }
    /**
     * Function to return static html response
     * @return string
     */
    public static function getRetrieveSuccessHtml($email){
        $url="../index.php";
        return <<<EOT
<h3>You phone number was sent to your email: $email</h3>
Please click <a href='{$url}'>here</a> to return back to form page.

EOT;
    }

    public static function setCookieError($name, $error)
    {
        //set validation cookies for 10 second
        setcookie($name, $error, time() + 10, "/");
    }
}