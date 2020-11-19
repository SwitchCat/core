<?php
/**
 * File:    Builder.php
 * Created: 18-11-20
 */

namespace SwitchCat\Templates;

use SwitchCat\Exception\SwitchCatException;

/**
 * Class Builder
 *
 * @author    Felix Eloy
 * @copyright 2020SwitchCat Agency
 * @licence   MIT
 *
 * @package   SwitchCat\Templates
 */
abstract class Builder
{
    /**
     * @param array  $data
     * @param string $layout
     * @return string
     */
    public static function start(array $data, string $layout):string
    {
        if(empty($layout))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'No layout defined');
        }
        if(!file_exists($layout))
        {
            throw new SwitchCatException([__CLASS__, __FUNCTION__], 'Layout file not found in ' . $layout );
        }
        ob_start();
        include $layout;
        $document = ob_get_contents();
        ob_end_clean();
        return $document;
    }
}