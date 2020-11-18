<?php
/**
 * File:    Assets.php
 * Created: 08-11-20
 */

namespace SwitchCat\Assets;


class Assets
{
    private array $assets;
    
    public function __construct()
    {
        $this->assets['js'] = [];
        $this->assets['css'] = [];
        $this->assets['image'] = [];
        $this->assets['video'] = [];
        $this->assets['pdf'] = [];
        $this->assets['text'] = [];


    }
    
    public function addAsset(string $type, string $name, string $file):void
    {
        if(key_exists($type, $this->assets))
        {
            if(file_exists($file))
            {
                $this->assets[$type] = ['name'=>$name, 'file'=>$file];
            }      
            else
            {
                throw new \SwitchCat\Assets\AssetsException('');
            }
        }
        else
        {
            throw new \SwitchCat\Assets\AssetsException('');
        }        
    }
    
    public function getAssets(string $type = ''):array
    {
        if ($type === '')
        {
            return $this->assets;
        }
        elseif (key_exists($type, $this->assets))
        {
            return $this->assets[$type];
        }
        else
        {
            throw new \SwitchCat\Assets\AssetsException('');
        }
    }
}