<?php
namespace Instagram\Request;

use App\Models\Base;
use Instagram\Common\CurlException;
use Instagram\Client\CurlClient;

abstract class Request extends CurlClient
{
    protected $response;

    /**
     * Run all request to server as : post, get, put ...
     *
     * @param $method
     * @param $uri
     * @param array $options
     * @param bool $checkReq
     * @return mixed
     */
    protected function sendRequest($method, $uri, array $options = [], $checkReq = false)
    {
        try {
            $this->setResponse(empty($options) ? $this->client->$method($uri) : $this->client->$method($uri, $options));
            if (!$this->checkRequest() && $checkReq) {
                new CurlException('Send request fail (status code : ' . $this->getStatusCode() . ')');
            }
        } catch (\Exception $e) {
            Base::writeLog(__METHOD__, $method . "=> url :" . $uri . ' options : ' . json_encode($options));
        }

        return $this->getResponse();
    }

    /**
     * @param $response
     */
    protected function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    protected function checkRequest()
    {
        $statusCode = $this->getStatusCode();
        if ($this->response && $statusCode === 200) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        try {
            return $this->getResponse()->getStatusCode();
        } catch (\Exception $e) {
            return new CurlException($e->getMessage());
        }
    }

}