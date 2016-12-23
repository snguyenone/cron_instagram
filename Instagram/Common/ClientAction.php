<?php
namespace Instagram\Common;

use GuzzleHttp\Client;
use Instagram\Config;

class ClientAction
{
    protected $path;

    /**
     * CookieJarForImage constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->setPath($path);
    }

    /**
     * @param $path string code of a image user instagram
     * @return $this
     */
    protected function setPath($path)
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
     * Get Cookie Jar for user action as: like, follow, unfollow, unlike
     *
     * @param $cookieJar
     * @return Client
     */
    public function getCookieJarForAction($cookieJar)
    {
        $curlCookie = new CurlCookiesJar(
            $this->getPath(),
            $cookieJar
        );
        var_dump("===111==", $curlCookie->runGetCookieToken()->getHeader());

        return new Client((new CurlHeader($curlCookie->getCookieJar(), 'test'))->getHeaderOptions());
    }

}