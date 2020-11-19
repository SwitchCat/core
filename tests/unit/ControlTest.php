<?php
/**
 * File:    ControlTest.php
 * Created: 18-11-20
 */

use PHPUnit\Framework\TestCase;
use SwitchCat\Control\Control;
use SwitchCat\Initializer\Initializer;
use SwitchCat\Control\ControlInterface;

class ControlTest extends TestCase
{
    /**
     * @covers \SwitchCat\Control\Control
     */
    public function testControlConstructsWithIniParams()
    {
        Initializer::init();
        $object = new Control();
        $objectReflection = new ReflectionObject($object);
        $property = $objectReflection->getProperty('IniParams');
        $this->assertIsObject($property);
        $this->assertNotEmpty($property);
    }

    /**
     * @covers \SwitchCat\Control\Control
     */
    public function testControlImplementsControlInterface()
    {
        Initializer::init();
        $object = new Control();
        $this->assertTrue($object instanceof ControlInterface);
    }
}