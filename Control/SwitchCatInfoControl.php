<?php
/**
 * File:    SwitchCatInfoControl.php
 * Created: 07-11-20
 */

namespace SwitchCat\Control;


final class SwitchCatInfoControl extends SwitchCatControl
{
    public function run(array $options = []): void
    {
        \SwitchCat\Cli\Cli::Climate()->br();
        $this->showOptions();
        die();
    }
}