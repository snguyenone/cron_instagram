<?php
namespace Instagram\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Instagram\Config;
use Instagram\Request\GetRequest;
use Instagram\Request\PostRequest;

class CurlLogin
{
    protected $response;
    protected $username;
    protected $password;
    protected $cookieJar;

    /**
     * CurlLogin constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        if (empty($username) || empty($password)) {
            throw new \Exception('Please enter value ' . $username . 'and' . $password . ' is not empty.');
        }

        $this->cookieJar = new CookieJar();
        $this->setUserName($username)->setPassword($password)->getTokenInsBeforeLogin();
        $this->login();
    }

    protected function setUserName($username)
    {
        $this->username = $username;

        return $this;
    }

    protected function getUserName()
    {
        return $this->username;
    }

    /**
     * @param $password
     * @return $this
     */
    protected function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getPassword()
    {
        return $this->password;
    }

    /**
     * @return PostRequest
     */
    public function login()
    {
        $post = new PostRequest(
            new Client((new CurlHeader($this->cookieJar))->getHeaderOptions())
        );

        $this->response = $post->postRequest(Config::insUrlLogin(), [
            'form_params' => [
                'username' => $this->getUserName(),
                'password' => $this->getPassword()
            ]
        ]);

        return $post;
    }

    /**
     * Check response if response data of user is null or need verify
     *
     * @return bool
     */
    public function checkResponse()
    {
        if(!isset($this->response) || empty($this->response)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function checkLogin($key = 'authenticated')
    {
        $resLog = json_decode($this->response->getBody()->getContents(), true);

        if (!isset($resLog[$key]) || $resLog[$key] == false) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    protected function getTokenInsBeforeLogin()
    {
        return (new GetRequest(new Client(['cookies' => $this->cookieJar])))->getRequest(Config::BASE_URL);
    }

    /**
     * @return CookieJar
     */
    public function getCookieJarLogin()
    {
        return $this->cookieJar;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

}