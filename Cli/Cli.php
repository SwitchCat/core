<?php

namespace SwitchCat\Cli;

/**
 * Class Cli
 * @package SwitchCat\Cli
 */
abstract class Cli
{
    /**
     * @var \League\CLImate\CLImate
     */
    private static \League\CLImate\CLImate $Climate;

    /**
     * @return \League\CLImate\CLImate
     */
    public static function Climate()
    {
        if(!isset(self::$Climate))
        {
            self::$Climate = new \League\CLImate\CLImate();
        }
        return self::$Climate;
    }
}