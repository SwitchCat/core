<?php declare(strict_types=1);
/**
 * File:    ManagerTest.php
 * Created: 18-11-20
 */

use PHPUnit\Framework\TestCase;
use SwitchCat\Exception\SwitchCatException;
use SwitchCat\Templates\Manager;

/**
 * Class ManagerTest
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 * @covers \SwitchCat\Templates\Manager
 */
class ManagerTest extends TestCase
{
    /**
     * @covers \SwitchCat\Templates\Manager::getDefaults
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetDefaultsThrowsExceptionWithMissingIniFile()
    {
        $this->expectException(SwitchCatException::class);
        $refClass  = new ReflectionClass('\SwitchCat\Templates\Manager');
        $refClass->setStaticPropertyValue('layouts', []);
        $refMethod = new ReflectionMethod('\SwitchCat\Templates\Manager', 'getDefaults');
        $refMethod->invoke(null, 'ghost.yaml');
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getDefaults
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetDefaultsThrowsExceptionWithEmptyIniFile()
    {
        $this->expectException(SwitchCatException::class);
        $refClass  = new ReflectionClass('\SwitchCat\Templates\Manager');
        $refClass->setStaticPropertyValue('layouts', []);
        $refMethod = new ReflectionMethod('\SwitchCat\Templates\Manager', 'getDefaults');
        $refMethod->invoke(null, 'empty.yaml');
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getDefaults
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetDefaultsReturnsArray()
    {
        $this->assertIsArray(Manager::getDefaults());
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getLayout
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetLayoutThrowsExceptionWithMissingIniFile()
    {
        $this->expectException(SwitchCatException::class);
        $refClass  = new ReflectionClass('\SwitchCat\Templates\Manager');
        $refClass->setStaticPropertyValue('layouts', []);
        $refMethod = new ReflectionMethod('\SwitchCat\Templates\Manager', 'getLayout');
        $refMethod->invoke(null, 'main','ghost.yaml');
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getLayout
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetLayoutThrowsExceptionWithEmptyIniFile()
    {
        $this->expectException(SwitchCatException::class);
        $refClass  = new ReflectionClass('\SwitchCat\Templates\Manager');
        $refClass->setStaticPropertyValue('layouts', []);
        $refMethod = new ReflectionMethod('\SwitchCat\Templates\Manager', 'getLayout');
        $refMethod->invoke(null, 'main','empty.yaml');
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getLayout
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetLayoutThrowsExceptionWithUnknownRequested()
    {
        $this->expectException(SwitchCatException::class);
        Manager::getLayout('unknown','layouts.yaml');
    }

    /**
     * @covers \SwitchCat\Templates\Manager::getLayout
     * @covers \SwitchCat\Templates\Manager::load
     * @covers \SwitchCat\Templates\Manager::ini
     * @throws SwitchCatException
     */
    public function testGetLayoutReturnsString()
    {
        $this->assertIsString(Manager::getLayout('main','layouts.yaml'));
    }

}