<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use app\Config;

class ConfigTest extends TestCase {

    protected function setUp()
    {
        $file=__DIR__."/../src/app.config.json";
        Config::load($file);
    }

    public function testItCanCreateConfigFromFile()
    {
        $getSecureEncryptionSaltFromArray = Config::get('encryptionSalt');
        $this->assertEquals("ThisIsVerySecureSaltHashString", $getSecureEncryptionSaltFromArray);
    }

    public function testItCanReadConfigValuesInArrays()
    {
        $databaseArrayConfig = Config::get('database');
        $this->debugToConsole($databaseArrayConfig['host']);
        $this->assertEquals('localhost', $databaseArrayConfig['host']);

    }

    protected function debugToConsole($var) {
        fwrite(STDERR, print_r($var, TRUE));
    }

}