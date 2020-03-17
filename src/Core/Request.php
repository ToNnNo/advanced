<?php

namespace App\Core;

use Doctrine\Common\Collections\ArrayCollection;

class Request
{
    /**
     * $_POST
     *
     * @var ArrayCollection
     */
    public $request;

    /**
     * $_GET
     *
     * @var ArrayCollection
     */
    public $query;

    /**
     * $_SERVER
     *
     * @var ArrayCollection
     */
    public $server;

    /**
     * Request constructor.
     * @param array $request
     * @param array $query
     * @param array $server
     */
    public function __construct(array $request, array $query, array $server)
    {
        $this->request = new ArrayCollection($request);
        $this->query = new ArrayCollection($query);
        $this->server = new ArrayCollection($server);
    }

    public static function createRequestFromGlobal()
    {
        return new static($_GET, $_POST, $_SERVER);
    }

    public function getHost()
    {
        return "http://" . $this->server['HTTP_HOST'];
    }

    public function getBaseDir()
    {
        return dirname($this->server['SCRIPT_FILENAME']);
    }

    public function getRequestUri()
    {
        return $this->server['REQUEST_URI'];
    }

    /**
     *  * http://localhost/mysite              returns an empty string
     *  * http://localhost/mysite/about        returns '/about'
     *  * http://localhost/mysite/enco%20ded   returns '/enco%20ded'
     *  * http://localhost/mysite/about?var=1  returns '/about'
     */
    public function getPathInfo()
    {
        if( $this->server['PATH_INFO'] ) {
            return $this->server['PATH_INFO'];
        }

        return "/".basename($this->server['PHP_SELF']);
    }

    /**
     *  * http://localhost/index.php         returns an empty string
     *  * http://localhost/index.php/page    returns an empty string
     *  * http://localhost/web/index.php     returns '/web'
     *  * http://localhost/we%20b/index.php  returns '/we%20b'
     */
    public function getBasePath()
    {
        return dirname($this->server['SCRIPT_NAME']);
    }

}