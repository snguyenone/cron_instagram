<?php
namespace Instagram\Common;

use Instagram\Config;

class CurlHeader
{
    protected $cookie;
    protected $token;

    public function __construct($cookie)
    {
        if (!isset($this->cookie)) {
            $this->setCookie($cookie)->setToken();
        }
    }

    public function getCookie()
    {
        return $this->cookie;
    }

    protected function setCookie($cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($cookies = [])
    {
        if (!empty($cookies)) {
            $this->setCookie($cookies);
        }

        if (empty($responseCookie = $this->getCookie()->toArray())) {
            new CurlException('Please confirm "cookies" for login Intagram');
        }

        $responseCookie = $cookies === [] ? $responseCookie : $cookies;

        foreach ($responseCookie as $cookie) {
            if ($cookie['Name'] === 'csrftoken' && $cookie['Value']) {
                $this->token = $cookie['Value'];
                break;
            }
        }

        if (!isset($this->token) || empty($this->token)) {
            new CurlException('Please confirm "token" for login Intagram');
        }

        return $this;
    }

    public function getHeaderOptions(array $options = [])
    {
        $optionsDefault = [
            'headers' => [
                "Origin"            => Config::BASE_URL,
                "Referer"           => Config::BASE_URL,
                "x-csrftoken"       => $this->getToken(),
                "dnt"               => 1,
                "Accept-Encoding"   => 'no-cache',
                'User-Agent'        => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36',
                'X-Requested-With'  => 'XMLHttpRequest',
                'X-Instagram-Ajax'  => '1'
            ],
            'cookies' => $this->getCookie()
        ];

        if ($options === []) {
            return $optionsDefault;
        }

        foreach ($options as $key => $option) {
            $optionsDefault[$key] = $option;
        }

        return $optionsDefault;
    }

}