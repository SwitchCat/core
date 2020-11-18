<?php

namespace SwitchCat\Control;

final class IndexControl extends HttpControl
{        
    public function __construct()
    {
        parent::__construct();
        $this->requested = 'index';
    }

    public function run(): void
    {
        $this->process();
        $this->response();
    }
    
    public function process(): void
    {
        parent::process();
        // Main template
        $this->data['main']['name'] = ['first' =>  (!empty(\SwitchCat\Initializer\Initializer::$ini['author']['name'])) ? \SwitchCat\Initializer\Initializer::$ini['author']['name'] : 'Sir'];
        
        // Header template
        $this->data['header']['title'] = \SwitchCat\Initializer\Initializer::$ini['params']['name'];
    }
}