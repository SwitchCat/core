<?php

namespace SwitchCat\Cache;

/**
 * Class FileCache
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 *
 * @package   SwitchCat\Cache
 */
class FileCache extends Cache
{

    /**
     * @var string $folder
     */
    private string $folder;

    /**
     * @var array
     */
    private array $collection;

    /**
     * FileCache constructor.
     * @param string $folder
     */
    public function __construct(string $folder)
    {
        $this->folder = $folder;
        $this->collection = \Symfony\Component\Yaml\Yaml::parseFile('ini/filecache.yaml');
        $this->update();
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key):string
    {
        if(file_exists($this->folder . $key . '.cached'))
        {
            return file_get_contents($this->folder . $key . '.cached');
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @param int    $ttl
     * @param bool   $override
     */
    public function set(string $key, string $value, int $ttl = 0, bool $override = TRUE):void
    {
        if(!file_exists($this->folder . $key . '.cached') || $override === TRUE)
        {
            file_put_contents($this->folder . $key . '.cached', $value);
            $this->collection[$key] = ($ttl === 0) ? $ttl : time() + $ttl;
        }
        else
        {
            throw new \SwitchCat\Cache\CacheException();
        }
    }

    /**
     * 
     */
    private function update():void
    {
        $newref = [];
        foreach ($this->collection as $key => $value)
        {
            if($value <= time() && $value !== 0)
            {
                unlink($this->folder . $value);
            }
            else
            {
                $newref[$key] = $value;
            }
        }
        $this->collection = $newref;
        unset($newref);
    }
}