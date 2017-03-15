<?php


namespace app\Contact;


trait EmailTrait {
    /**
     * @param $to
     * @param $subject
     * @param $message
     * @return void
     */
    private function sendEmail($to, $subject, $message)
    {
        $result=mail($to, $subject,$message);
        if(!$result)
        {
            error_log("Cant send email please check your sendmail_path php.ini configuration or system log", 0);
        }
    }
}