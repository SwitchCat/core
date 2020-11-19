<?php declare(strict_types=1);

/**
 * File:    AjaxControlTest.php
 * Created: 19-11-20
 */

use Gregwar\Cache\Cache;
use PHPUnit\Framework\TestCase;
use SwitchCat\Control\AjaxControl;
use SwitchCat\Control\ControlInterface;
use SwitchCat\Exception\SwitchCatException;
use SwitchCat\Initializer\Initializer;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AjaxControlTest
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 * @covers \SwitchCat\Control\AjaxControl
 */
class AjaxControlTest extends TestCase
{
    /**
     * @covers \SwitchCat\Control\AjaxControl
     */
    public function testAjaxControlImplementsControlInterface()
    {
        Initializer::init();
        $object = new AjaxControl();
        $this->assertTrue($object instanceof ControlInterface);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl
     */
    public function testAjaxControlHasRequestParam()
    {
        Initializer::init();
        $object = new AjaxControl();
        $objectReflection = new ReflectionObject($object);
        $property = $objectReflection->getProperty('Request');
        $this->assertIsObject($property);
        $this->assertNotEmpty($property);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::validate
     */
    public function testAjaxControlValidateDetectsHeaderAcceptsValidatesTextHtml()
    {
        $string = 'text/plain;q=0.5, application/javascript, text/*;q=0.8, */*;q=0.3';
        $acceptHeader = AcceptHeader::fromString($string);
        $this->assertTrue($acceptHeader->has('application/javascript'));
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::validate
     */
    public function testAjaxControlValidateDetectsHeaderAcceptsDoesNotValidateNotTextHtml()
    {
        $string = 'text/plain;q=0.5, text/javascript, text/*;q=0.8, */*;q=0.3';
        $acceptHeader = AcceptHeader::fromString($string);
        $this->assertFalse($acceptHeader->has('text/html'));
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCreatesCacheObject()
    {
        $Cache = new Cache();
        $this->assertInstanceOf(Cache::class, $Cache);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessUsesExistingReadableAndWritableDirectory()
    {
        $this->assertDirectoryExists('documents/');
        $this->assertDirectoryIsReadable('documents/');
        $this->assertDirectoryIsWritable('documents/');
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCachingCreatesCacheWithCacheFileNotExistAndTtlZero()
    {
        if(file_exists('documents/test.json'))
        {
            rename( 'documents/test.json', 'documents/test.json.test');
        }
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'test.json',
            ['max-age' => 0],
            function()
            {
                json_encode([]);
            }
        );
        $this->assertFileExists('documents/test.json');
        if(file_exists('documents/test.json.test'))
        {
            rename( 'documents/test.json.test', 'documents/test.json');
        }
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCachingCreatesCacheWithCacheFileExistAndTtlZero()
    {
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'test.json',
            ['max-age' => 0],
            function()
            {
                json_encode([]);
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $this->assertFileExists('documents/test.json');
        $this->assertGreaterThan($before_cache_date, $after_cache_date);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCachingCreatesCacheWithCacheFileNotExistAndTtlMinute()
    {
        if(file_exists('documents/test.json'))
        {
            rename( 'documents/test.json', 'documents/test.json.test');
        }
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'test.json',
            ['max-age' => 60],
            function()
            {
                json_encode([]);
            }
        );
        $this->assertFileExists('documents/test.json');
        if(file_exists('documents/test.json.test'))
        {
            rename( 'documents/test.json.test', 'documents/test.json');
        }
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCachingCreatesCacheWithCacheFileExistAndTtlTenSeconds()
    {
        sleep(11);
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'test.json',
            ['max-age' => 10],
            function()
            {
                json_encode([]);
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $this->assertFileExists('documents/test.json');
        $this->assertGreaterThan($before_cache_date, $after_cache_date);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessCachingNotCreatesCacheWithCacheFileExistAndTtlTenSeconds()
    {
        sleep(5);
        $before_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $Cache = new Cache;
        $Cache->setCacheDirectory('documents');
        $Cache->setPrefixSize(0);
        $document = $Cache->getOrCreate
        (
            'test.json',
            ['max-age' => 10],
            function()
            {
                json_encode([]);
            }
        );
        $after_cache_date = date ("F d Y H:i:s.", filemtime('documents/test.json'));
        $this->assertFileExists('documents/test.json');
        $this->assertEquals($before_cache_date, $after_cache_date);
    }

    /**
     * @covers \SwitchCat\Control\AjaxControl::process
     */
    public function testAjaxControlProcessSendsResponse()
    {
        // Build the response object
        $Response = new Response(
            'something',
            Response::HTTP_OK,
            ['content-type' => 'application/javascript']
        );
        $this->assertEquals(200,$Response->getStatusCode());
    }
}