<?php

namespace Niden\Tests\unit\config;

use function Niden\Functions\appPath;
use \UnitTester;

class AutoloaderCest
{
    public function checkDotenvVariables(UnitTester $I)
    {
        require_once appPath('config/autoload.php');

        $I->assertNotEquals(false, getenv('APP_DEBUG'));
        $I->assertNotEquals(false, getenv('APP_ENV'));
        $I->assertNotEquals(false, getenv('APP_URL'));
        $I->assertNotEquals(false, getenv('APP_NAME'));
        $I->assertNotEquals(false, getenv('APP_BASE_URI'));
        $I->assertNotEquals(false, getenv('APP_SUPPORT_EMAIL'));
        $I->assertNotEquals(false, getenv('APP_TIMEZONE'));
        $I->assertNotEquals(false, getenv('CACHE_PREFIX'));
        $I->assertNotEquals(false, getenv('CACHE_LIFETIME'));
        $I->assertNotEquals(false, getenv('DATA_API_MEMCACHED_HOST'));
        $I->assertNotEquals(false, getenv('DATA_API_MEMCACHED_PORT'));
        $I->assertNotEquals(false, getenv('DATA_API_MEMCACHED_WEIGHT'));
        $I->assertNotEquals(false, getenv('DATA_API_MYSQL_NAME'));
        $I->assertNotEquals(false, getenv('LOGGER_DEFAULT_FILENAME'));
        $I->assertNotEquals(false, getenv('VERSION'));

        $I->assertEquals('true', getenv('APP_DEBUG'));
        $I->assertEquals('development', getenv('APP_ENV'));
        $I->assertEquals('http://api.phalcon.ld', getenv('APP_URL'));
        $I->assertEquals('/', getenv('APP_BASE_URI'));
        $I->assertEquals('team@phalconphp.com', getenv('APP_SUPPORT_EMAIL'));
        $I->assertEquals('UTC', getenv('APP_TIMEZONE'));
        $I->assertEquals('api_cache_', getenv('CACHE_PREFIX'));
        $I->assertEquals(86400, getenv('CACHE_LIFETIME'));
        $I->assertEquals(11211, getenv('DATA_API_MEMCACHED_PORT'));
        $I->assertEquals(100, getenv('DATA_API_MEMCACHED_WEIGHT'));
        $I->assertEquals('gonano', getenv('DATA_API_MYSQL_NAME'));
        $I->assertEquals('api', getenv('LOGGER_DEFAULT_FILENAME'));
        $I->assertEquals('20180401', getenv('VERSION'));
    }
}