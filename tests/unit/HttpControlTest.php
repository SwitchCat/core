<?php declare(strict_types=1);

/**
 * File:    HttpControlTest.php
 * Created: 18-11-20
 */

use Gregwar\Cache\Cache;
use PHPUnit\Framework\TestCase;
use SwitchCat\Control\HttpControl;
use SwitchCat\Initializer\Initializer;
use SwitchCat\Control\ControlInterface;
use SwitchCat\Exception\SwitchCatException;
use SwitchCat\Templates\Builder;
use SwitchCat\Templates\Manager;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HttpControlTest
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 * @covers \SwitchCat\Control\HttpControl
 */
class HttpControlTest extends TestCase
{
    /**
     * @covers \SwitchCat\Control\HttpControl
     */
    public function testHttpControlImplementsControlInterface()
    {
        Initializer::init();
        $object = new HttpControl();
        $this->assertTrue($object instanceof ControlInterface);
    }

    /**
     * @covers \SwitchCat\Control\HttpControl
     */
    public function testHttpControlHasRequestParam()
    {
        Initializer::init();
        $object = new HttpControl();
        $objectReflection = new ReflectionObject($object);
        $property = $objectReflection->getProperty('Request');
        $this->assertIsObject($property);
        $this->assertNotEmpty($property);
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::validate
     */
    public function testHttpControlValidateDetectsHeaderAcceptsValidatesTextHtml()
    {
        $string = 'text/plain;q=0.5, text/html, text/*;q=0.8, */*;q=0.3';
        $acceptHeader = AcceptHeader::fromString($string);
        $this->assertTrue($acceptHeader->has('text/html'));
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::validate
     */
    public function testHttpControlValidateDetectsHeaderAcceptsDoesNotValidateNotTextHtml()
    {
        $string = 'text/plain;q=0.5, text/javascript, text/*;q=0.8, */*;q=0.3';
        $acceptHeader = AcceptHeader::fromString($string);
        $this->assertFalse($acceptHeader->has('text/html'));
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessCreatesCacheObject()
    {
        $Cache = new Cache();
        $this->assertInstanceOf(Cache::class, $Cache);
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessUsesExistingReadableAndWritableDirectory()
    {
        $this->assertDirectoryExists('documents/');
        $this->assertDirectoryIsReadable('documents/');
        $this->assertDirectoryIsWritable('documents/');
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessCachingCreatesCacheWithCacheFileNotExistAndTtlZero()
    {
        if(file_exists('documents/main.html'))
        {
            rename( 'documents/main.html', 'documents/main.html.test');
        }
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'main' . '.html',
            ['max-age' => 0],
            function()
            {
                Builder::start([], Manager::getLayout('main'));
            }
        );
        $this->assertFileExists('documents/' . 'main' . '.html');
        if(file_exists('documents/main.html.test'))
        {
            rename( 'documents/main.html.test', 'documents/main.html');
        }
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessCachingCreatesCacheWithCacheFileExistAndTtlZero()
    {
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'main' . '.html',
            ['max-age' => 0],
            function()
            {
                Builder::start([], Manager::getLayout('main'));
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $this->assertFileExists('documents/' . 'main' . '.html');
        $this->assertGreaterThan($before_cache_date, $after_cache_date);
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessCachingCreatesCacheWithCacheFileNotExistAndTtlMinute()
    {
        if(file_exists('documents/main.html'))
        {
            rename( 'documents/main.html', 'documents/main.html.test');
        }
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'main' . '.html',
            ['max-age' => 60],
            function()
            {
                Builder::start([], Manager::getLayout('main'));
            }
        );
        $this->assertFileExists('documents/' . 'main' . '.html');
        if(file_exists('documents/main.html.test'))
        {
            rename( 'documents/main.html.test', 'documents/main.html');
        }
    }

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     *//*
    public function testHttpControlProcessCachingCreatesCacheWithCacheFileExistAndTtlTenSeconds()
    {
        sleep(11);
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'main' . '.html',
            ['max-age' => 10],
            function()
            {
                Builder::start([], Manager::getLayout('main'));
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $this->assertFileExists('documents/' . 'main' . '.html');
        $this->assertGreaterThan($before_cache_date, $after_cache_date);
    }*/

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     *//*
    public function testHttpControlProcessCachingNotCreatesCacheWithCacheFileExistAndTtlTenSeconds()
    {
        sleep(5);
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'main' . '.html',
            ['max-age' => 10],
            function()
            {
                Builder::start([], Manager::getLayout('main'));
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/main.html'));
        $this->assertFileExists('documents/' . 'main' . '.html');
        $this->assertEquals($before_cache_date, $after_cache_date);
    }*/

    /**
     * @covers \SwitchCat\Control\HttpControl::process
     */
    public function testHttpControlProcessSendsResponse()
    {
        // Build the response object
        $Response = new Response(
            'something',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        $this->assertEquals(200,$Response->getStatusCode());
    }


}