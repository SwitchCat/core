<?php
/**
 * File:    ControlTest.php
 * Created: 18-11-20
 */

namespace SwitchCat\Control;

/**
 * Interface ControlInterface
 * @package SwitchCat\Control
 */
interface ControlInterface
{
    public function run():void;

    public function validate():void;

    public function process():void;

    public function response():void;
}