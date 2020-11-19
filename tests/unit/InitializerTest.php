<?php declare(strict_types=1);
/**
 * File:    InitializerTest.php
 * Created: 18-11-20
 */

use PHPUnit\Framework\TestCase;
use SwitchCat\Initializer\Initializer;
use SwitchCat\Exception\SwitchCatException;

/**
 * Class InitializerTest
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 * @covers \SwitchCat\Initializer\Initializer
 */
class InitializerTest extends TestCase
{
    /**
     * @covers \SwitchCat\Initializer\Initializer::init
     * @throws SwitchCatException
     */
    public function testInitializerInitWithoutIniFileThrowsException()
    {
        $this->expectException(SwitchCatException::class);
        Initializer::init('');
    }

    /**
     * @covers \SwitchCat\Initializer\Initializer::params
     * @covers \SwitchCat\Initializer\Initializer::params
     * @throws SwitchCatException
     */
    public function testInitializerParamsWithoutInitThrowsException()
    {
        $this->expectException(SwitchCatException::class);
        $refClass  = new ReflectionClass('\SwitchCat\Initializer\Initializer');
        $refClass->setStaticPropertyValue('params', []);
        $refMethod = new ReflectionMethod('\SwitchCat\Initializer\Initializer', 'params');
        $refMethod->invoke(null);
    }

    /**
     * @covers \SwitchCat\Initializer\Initializer::init
     * @throws SwitchCatException
     */
    public function testInitializerInitWithInvalidIniFileThrowsException()
    {
        $this->expectException(SwitchCatException::class);
        Initializer::init('none.xml');
    }

    /**
     * @covers \SwitchCat\Initializer\Initializer::init
     * @throws SwitchCatException
     */
    public function testInitializerInitWithDefaultEmptyIniFileThrowsException()
    {
        $this->expectException(SwitchCatException::class);
        Initializer::init('ini/empty.yaml');
    }

    /**
     * @covers \SwitchCat\Initializer\Initializer::init
     * @covers \SwitchCat\Initializer\Initializer::params
     * @throws SwitchCatException
     */
    public function testInitializerInitWithValidIniFileSetsParamsAndReturnsArray()
    {
        Initializer::init('ini/app.yaml');
        $this->assertIsArray(Initializer::params());
    }


}