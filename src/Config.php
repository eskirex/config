<?php

namespace Eskirex\Component\Config;

use Eskirex\Component\Config\Traits\ConfigTrait;

class Config
{
    use ConfigTrait;

    public function __construct($type)
    {
        $this->init($type);
    }

    public function get($name)
    {
        return $this->doFetch($name);
    }

    public function all()
    {
        return $this->doFetch();
    }
    
    public static function config($configArr)
    {
        self::doSetRuntimeConfig($configArr);
    }


}