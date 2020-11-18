<?php

namespace SwitchCat\Data;

/**
 * Class DataException
 * @package SwitchCat\Database
 */
class DataException extends \SwitchCat\Exception\SwitchCatException
{
    /**
     * DataException constructor.
     * @param string $message
     * @param string $class
     * @param string $method
     * @param string $query
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", string $class = "", string $method = "", string $query = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->info['message'] = $message;
        $this->info['class'] = $class;
        $this->info['method'] = $method;
        $this->info['query'] = $query;
        $this->info['template'] = 'templates/exceptions/data.exception.template.php';
    }
}