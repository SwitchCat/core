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
     * SwitchCatException constructor.
     * @param array           $info
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $info, string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->info = $info;
    }

    /**
     * @return array
     */
    public function getInfo():array
    {
        return $this->info;
    }
}