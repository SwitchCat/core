<?php


namespace SwitchCat\Control;


class AjaxControl extends Control
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request $Request
     */
    private \Symfony\Component\HttpFoundation\Request $Request;

    /**
     * HttpControl constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->Request = new \Symfony\Component\HttpFoundation\Request($_POST, $_SESSION);
    }

    /**
     * Access request vars with Request object
     * @link https://symfony.com/doc/current/components/http_foundation.html
     * @return bool
     */
    public function validate(): bool
    {
        return TRUE;
    }
}