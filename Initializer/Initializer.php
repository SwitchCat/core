<?php declare(strict_types=1);
/**
 * File:    ControlTest.php
 * Created: 18-11-20
 */

namespace SwitchCat\Initializer;

use SwitchCat\Exception\SwitchCatException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Initializer
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 *
 * @package   SwitchCat\Initializer
 */
abstract class Initializer
{
    /**
     * @var array $params
     */
    private static array $params = [];

    /**
     * @param string $inifile
     * @throws SwitchCatException
     */
    public static function init(string $inifile = 'ini/app.yaml'):void
    {
        if(!file_exists($inifile))
        {
            throw new SwitchCatException(['Unable to find ini file: ' . $inifile]);
        }
        self::$params = (is_array($params = Yaml::parseFile($inifile))) ? $params : [];
        if(empty(self::$params))
        {
            throw new SwitchCatException(['Ini file seems empty. Please setup app ini file.']);
        }
    }

    /**
     * @return array
     * @throws SwitchCatException
     */
    public static function params():array
    {
        if(self::$params)
        {
            return self::$params;
        }
        throw new SwitchCatException(['Ini data not set.', __CLASS__, __FUNCTION__]);
    }
    
    /**
     * @param array $params
     * @return bool
     */
    /*
    public static function createIniFile(array $params):bool
    {
        $ini =
            [
                'params'    =>
                    [
                        'name'          =>  $params['app_name'],
                        'description'   =>  $params['app_description'],
                        'license'       =>  $params['license']
                    ],
                'author'   =>
                    [
                        'name'          =>  $params['author'],
                        'company'       =>  $params['company'],
                        'email'         =>  $params['email'],
                        'phone'         =>  $params['phone'],
                        'country'       =>  $params['country'],
                        'city'          =>  $params['city'],
                        'zip'           =>  $params['zip'],
                        'street'        =>  $params['street'],
                        'housenumber'   =>  $params['housenumber'],
                        'letterbox'     =>  $params['letterbox'],
                        'website'       =>  $params['website']
                    ],
                'app'       =>
                    [
                        'sessions'      =>  true,
                        'language'      =>  $params['app_default_language'],
                        'mode'          =>  'DEV',
                        'cache'         =>  'Void'
                    ],
                'database'  =>
                    [
                        'name'          =>  $params['app_database'],
                        'user'          =>  '',
                        'password'      =>  ''
                    ]
            ];
        
        $yaml = Yaml::dump($ini);

        file_put_contents('ini/app.yaml', $yaml);

        return TRUE;
    }*/
}