<?php
namespace Instagram\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Instagram\Request\GetRequest;
use Instagram\Request\PostRequest;

class CurlCookiesJar
{
    protected $cookieJar;
    protected $path;

    /**
     * BuildGetCookiesJar constructor.
     * @param string $path
     * @param string $cookieJar
     */
    public function __construct($path, $cookieJar = '')
    {
        $this->setPath($path);
        $cookieJar ? $this->setCookieJar($cookieJar) : $this->setCookieJar(1);
        var_dump("=======",$cookieJar);
    }

    /**
     * @param $cookieJar
     */
    public function setCookieJar($cookieJar)
    {
        $this->cookieJar = $cookieJar;
    }

    /**
     * @return mixed
     */
    public function getCookieJar()
    {
        return $this->cookieJar;
    }

    /**
     * Path for get cookie jar
     *
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function runGetCookieToken()
    {
        return (new GetRequest(new Client(['cookies' => $this->getCookieJar()])))->getRequest($this->getPath());
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function runPostCookieToken($params = [])
    {
        return (new PostRequest(new Client(['cookies' => $this->getCookieJar()])))->postRequest($this->getPath(), $params);
    }

}