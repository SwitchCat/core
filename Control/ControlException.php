<?php

namespace SwitchCat\Control;

/**
 * Class ControlException
 * @package SwitchCat\Control
 */
class ControlException extends \SwitchCat\Exception\SwitchCatException
{
    /**
     * ControlException constructor.
     * @param string $message
     * @param string $class
     * @param string $method
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", string $class = "", string $method = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->info['message'] = $message;
        $this->info['class'] = $class;
        $this->info['method'] = $method;
        $this->info['template'] = 'templates/exceptions/control.exception.template.php';
    }
}