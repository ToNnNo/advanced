<?php

namespace App\Utils;

class Singleton
{
    private $name;

    private static $instance = null;

    private function __construct(){ }

    private function __clone(){ }

    public final static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new Singleton();
        }

        return self::$instance;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}