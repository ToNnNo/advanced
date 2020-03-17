<?php


namespace App\Core;


class Response
{
    private $content;

    public function __construct($content = "")
    {
        $this->content = $content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function __toString()
    {
        return $this->content;
    }

}