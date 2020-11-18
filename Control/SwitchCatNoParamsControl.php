<?php
/**
 * File:    SwitchCatNoParamsControl.php
 * Created: 07-11-20
 */

namespace SwitchCat\Control;

final class SwitchCatNoParamsControl extends SwitchCatControl
{
    public function run(array $options = []): void
    {
        $this->showTitle();
        \SwitchCat\Cli\Cli::Climate()->red('This script requires at least on parameter [-f]');
        \SwitchCat\Cli\Cli::Climate()->br();
        $this->showOptions();
        die();
    }
}