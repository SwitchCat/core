<?php

namespace SwitchCat\Connections;

use SwitchCat\Initializer\Initializer;

/**
 * Class ConnectionsException
 * @package SwitchCat\Connections
 */
class ConnectionsException extends \SwitchCat\Exception\SwitchCatException
{
    /**
     * ConnectionsException constructor.
     * @param string $message
     * @param string $class
     * @param string $method
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $class = "", $method = "", $dsn = "", $username = "", $password = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->info['message'] = $message;
        $this->info['class'] = $class;
        $this->info['method'] = $method;
        $this->info['dsn'] = $dsn;
        $this->info['username'] = (Initializer::getAppStatus() === 'DEV')  ? $username : '';
        $this->info['password'] = (Initializer::getAppStatus() === 'DEV')  ? $password : '';
        $this->info['template'] = 'templates/exceptions/connections.exception.template.php';
    }
}