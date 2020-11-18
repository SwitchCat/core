<?php declare(strict_types=1);
/**
 * File:    ControlTest.php
 * Created: 18-11-20
 */

namespace SwitchCat\Exception;

/**
 * Class SwitchCatException
 * @package SwitchCat\Exception
 */
class SwitchCatException extends \Exception
{
    /**
     * @var array $info
     */
    protected array $info;

    /**
     * ControlException constructor.
     * @param string $message
     * @param string $class
     * @param string $method
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $params, $message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $update
     */
    public function updateMessage(string $update):void
    {
        $this->info['message'] .= $update;
        $this->message = $this->info['message'];
    }

    /**
     * @return array
     */
    public function getInfo():array
    {
        return $this->info;
    }

    /**
     *
     */
    public function dumpInfo():void
    {
        var_dump($this->info);
    }
}