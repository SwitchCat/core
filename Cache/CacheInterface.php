<?php
/**
 * File:    CacheInterface.php
 * Created: 09-11-20
 */

namespace SwitchCat\Cache;


interface CacheInterface
{
    public function __construct();
    
    public function update();
    
    public function get();
    
    public function set();
}