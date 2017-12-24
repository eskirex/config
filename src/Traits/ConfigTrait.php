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
    public static $runtimeConfig = [];


    /**
     * @var Dotify
     */
    public $selected;

    protected function init($type, $dir = false)
    {
        $fileFullName = ($dir ?: static::$runtimeConfig->get('dir')) . "$type.php";
        $readFile = $this->readFile($fileFullName);
        $this->selected = new Dotify($readFile);
    }

    protected function doFetch($key = false)
    {
        if ($key !== false) {
            return $this->selected->get($key);
        }

        return $this->selected->all();
    }

    protected function readFile($fileFullName)
    {
        if (file_exists($fileFullName) === true) {
            return include $fileFullName;
        }

        throw new ConfigNotFoundException();
    }

    protected static function doSetRuntimeConfig($arr)
    {
        static::$runtimeConfig = new Dotify(static::$runtimeConfig);

        if (isset($arr['dir'])) {
            if (is_dir($arr['dir'])) {
                static::$runtimeConfig->set('dir', $arr['dir']);
            }
        }
    }


}