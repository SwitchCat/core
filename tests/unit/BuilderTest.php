<?php declare(strict_types=1);
/**
 * File:    BuilderTest.php
 * Created: 18-11-20
 */

use PHPUnit\Framework\TestCase;
use SwitchCat\Templates\Builder;
use SwitchCat\Exception\SwitchCatException;

/**
 * Class BuilderTest
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 * @covers \SwitchCat\Templates\Builder
 */
class BuilderTest extends TestCase
{
    /**
     * @covers \SwitchCat\Templates\Builder::start
     * @throws SwitchCatException
     */
    public function testStartThrowsExceptionWithEmptyLayoutParam()
    {
        $this->expectException(SwitchCatException::class);
        Builder::start([],'');
    }

    /**
     * @covers \SwitchCat\Templates\Builder::start
     * @throws SwitchCatException
     */
    public function testStartThrowsExceptionWithLayoutFileNotFound()
    {
        $this->expectException(SwitchCatException::class);
        Builder::start([],'layouts/ghost.layout.php');
    }

    /**
     * @covers \SwitchCat\Templates\Builder::start
     * @throws SwitchCatException
     */
    public function testStartReturnsString()
    {
        $this->assertIsString(Builder::start([],'layouts/main.layout.php'));
    }
}