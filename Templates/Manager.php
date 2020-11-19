<?php
/**
 * File:    Manager.php
 * Created: 18-11-20
 */

namespace SwitchCat\Templates;


use SwitchCat\Exception\SwitchCatException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Manager
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 *
 * @package   SwitchCat\Templates
 */
abstract class Manager
{
    /**
     * @var array $layouts
     */
    private static array $layouts;

    /**
     * @param string $requested
     * @return array
     */
    public static function getDefaults(string $file = 'ini/layouts.yaml'): array
    {
        self::ini($file);
        return self::$layouts['defaults'];
    }

    /**
     * @param string $requested
     * @return string
     * @throws SwitchCatException
     */
    public static function getLayout(string $requested, $file = 'ini/layouts.yaml'): string
    {
        self::ini($file);
        if(!key_exists($requested, self::$layouts['collection']))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'Requested document layout not found');
        }
        return self::$layouts['collection'][$requested];
    }

    /**
     * @throws SwitchCatException
     */
    private static function load(string $file = 'ini/layouts.yaml'): void
    {
        if (!file_exists($file))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'Unable to find ini file: ' . $file);
        }
        self::$layouts = (is_array($layouts = Yaml::parseFile($file))) ? $layouts : [];
        if (empty(self::$layouts))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'Defaults file seems empty. Please setup template defaults file.');
        }
    }

    private static function ini(string $file):void
    {
        if(!isset(self::$layouts) || empty(self::$layouts))
        {
            self::load($file);
        }
    }
}