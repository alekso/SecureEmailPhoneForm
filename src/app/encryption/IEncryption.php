<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/27/2016
 * Time: 8:49 AM
 */

namespace app\encryption;


/**
 * Interface IEncryption
 * @package app\encryption
 */
interface IEncryption
{
    public function hash($string);
    public function encrypt($string, $key);
    public function decrypt($string, $key);
}