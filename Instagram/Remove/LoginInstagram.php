<?php
namespace Instagram;

use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\CookieJar;
use Instagram\Common\CurlHeader;
use Instagram\Common\CurlLogin;

class LoginInstagram
{
    protected $cookieJar;
    protected $common;

    public function __construct($username, $password)
    {
        $this->cookieJar = new CookieJar();
        parent::__construct($username, $password);
        $this->getTokenInsBeforeLogin()->login();
    }

    protected function getTokenInsBeforeLogin()
    {
        (new Client(['cookies' => $this->cookieJar]))->get(BASE_URL);
        $this->common = new CurlHeader($this->cookieJar);

        return $this;
    }

    protected function login()
    {
        $this->response = (new Client($this->common->getHeaderOptions()))->post(INS_URL_LOGIN, [
            'form_params' => [
                'username' => $this->getUserName(),
                'password' => $this->getPassword()
            ]
        ]);
    }

    public function getCookieJarLogin()
    {
        return $this->cookieJar;
    }

}