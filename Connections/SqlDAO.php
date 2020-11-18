<?php
/**
 * Class DAO
 *
 * MYSQL PDO DATABASE CONNECTION CLASS
 * > Creates or catches the database connection
 *
 * VERSION:             1.5
 * CREATED:             5-10-2013
 * LAST MODIFIED:		30-3-2020
 * WRITTEN BY:          Felix Eloy & Paul Kiekens
 * NOTES:
 *          >* added PDO parameters
 *          >* adapted to PHP 7.4
 *          >* added database selection as parameter instead of hardcoded
 *          >* added exception throwing in case no database could be defined
 *          >* added exception throwing in case connection with database could not be established
 *          >* Bug: Database switching was not behaving accordingly
 *          >* getConnection() parameter $dbname not allowed to be NULL anymore
 *          >* Return of getConnection method changed from 'object' to 'PDO'
 *          >* Added DocBlocks
 *          >* Added usage of \Webmozart\Assert\Assert:: library
 *          >* Replacing \Webmozart\Assert library with native SwitchCat Exception
 *          >* Integrating \SwitchCat\Exception\ConnectionsException
 *          >* Received namespace
 *          >* Is now part of SwitchCat Framework
 * TODO:
 *          >* Add user, password and host definition by parameter instead of hardcoded
 **/

namespace SwitchCat\Connections;

use \PDO;

abstract class SqlDAO
{
    /**
     * @var $connection
     */
    private static $connection;

    /**
     * @var $dbname
     */
    private static $dbname;

    /**
     * @param string|NULL $dbname
     * @return PDO
     * @throws \SwitchCat\Connections\ConnectionsException
     */
    public static function getConnection(string $dbname):PDO
    {
        // Check if database has been defined and corresponds to the required database
        if(is_null(self::$dbname) || $dbname !== self::$dbname)
        {
            // Redefine database if necessary
            self::$dbname = $dbname;
            self::$connection = NULL;
        }

        // Throw exception if no database could be defined
        if(is_null(self::$dbname))
        {
            throw new \SwitchCat\Connections\ConnectionsException('Attempted to connect to undefined SQL database',__CLASS__,__FUNCTION__, '', '', '');
        }

        // Create connection if not yet done
        if (is_null(self::$connection))
        {
            $user = 'root';
            $dsn = 'mysql:host=localhost;dbname=' . self::$dbname;
            $pwd = 'abracadabra';

            self::$connection = new PDO
            (
                $dsn,
                $user,
                $pwd,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        if(!is_object(self::$connection))
        {
            throw new \SwitchCat\Connections\ConnectionsException('Connection to SQL database could not be established.',__CLASS__,__FUNCTION__,$dsn,$user,$pwd);
        }

        // Return connection
        return self::$connection;
    }
}