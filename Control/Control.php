<?php declare(strict_types=1);
/**
 * File:    ControlTest.php
 * Created: 18-11-20
 */

namespace SwitchCat\Control;

use SwitchCat\Initializer\Initializer;

/**
 * Class Control
 * @author Felix Eloy
 * @copyright SwitchCat Agency
 *@package SwitchCat\Control
 */
class Control implements ControlInterface
{
    /**
     * @var object $IniParams
     */
    protected object $IniParams;

    /**
     * @var array $data
     */
    protected array $data;

    /**
     * Control constructor.
     * @throws \SwitchCat\Exception\SwitchCatException
     */
    public function __construct()
    {
        $this->IniParams = (object)Initializer::params();
    }

    /**
     * @throws \SwitchCat\Exception\SwitchCatException
     */
    public function run(): void
    {

    }

    /**
     * @throws \SwitchCat\Exception\SwitchCatException
     */
    public function validate():void
    {

    }

    /**
     * @throws \SwitchCat\Exception\SwitchCatException
     */
    public function process(): void
    {

    }

    /**
     * @throws \SwitchCat\Exception\SwitchCatException
     */
    public function response(): void
    {

    }
}