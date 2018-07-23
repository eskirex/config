<?php

namespace Eskirex\Component\Config\Traits;

use Composer\Config;
use Eskirex\Component\Config\Exceptions\ConfigNotFoundException;
use Eskirex\Component\Dotify\Dotify;

trait ConfigTrait
{
    /**
     * @var Dotify
     */
    public static $config;

    /**
     * @var Dotify
     */
    public $data;


    protected function init($type, $dir = false)
    {
        $fileFullName = ($dir ?: $this->getConfig('dir')) . "$type.php";
        $readFile = $this->readFile($fileFullName);
        $this->data = $readFile;
    }


    protected static function doConfigure($set)
    {
        if (static::$config === null) {
            static::$config = new Dotify();
        }

        if (is_array($set)) {
            static::$config->setArray($set);
        }
    }


    protected function getConfig($get)
    {
        if (static::$config === null) {
            return null;
        }

        if (static::$config->has($get)) {
            return static::$config->get($get);
        }

        return null;
    }


    protected function doFetch($key = false)
    {
        if ($key !== false) {
            return (new Dotify($this->data))->get($key);
        }

        return (new Dotify($this->data))->all();
    }


    protected function readFile($fileFullName)
    {
        if (file_exists($fileFullName) === true) {
            return include $fileFullName;
        }

        throw new ConfigNotFoundException();
    }
}