<?php

namespace SwitchCat\Control;


class SwitchCatControl extends CliControl
{
    protected function showTitle()
    {
        \SwitchCat\Cli\Cli::Climate()->clear();
        \SwitchCat\Cli\Cli::Climate()->LightCyan()->bold()->out('### S W I T C H C A T -- F R A M E W O R K ### ');
        \SwitchCat\Cli\Cli::Climate()->br();
        \SwitchCat\Cli\Cli::Climate()->LightRed()->bold()->out('----------- Administration System ------------');
        \SwitchCat\Cli\Cli::Climate()->br();
        \SwitchCat\Cli\Cli::Climate()->br();
    }

    protected function showOptions()
    {
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f init -> initialise the app by entering base app values and create ini file');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f update-ini -r <variable> -v <value> -> give a new value to one of the ini parameters');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f ini-vars -> list all ini variables');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f show-ini -> list all initialised variables with values');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f model -r <table name> -> create a model for a table');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f control -r <controller name> -> create a new controller');
        \SwitchCat\Cli\Cli::Climate()->green()->out('-f template <switchcat/tpl_xxx> -> register a new template');
        \SwitchCat\Cli\Cli::Climate()->br();
    }
}