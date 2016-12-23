<?php
namespace Instagram\Request;

use Instagram\Common\CurlException;
use Instagram\Common\Timers;
use Instagram\Config;

class PostRequest extends Request
{
    /**
     * @param $uri
     * @param array $formParams
     * @return mixed
     */
    public function postRequest($uri, array $formParams = [])
    {
        return $this->sendRequest('post', $uri, $formParams);
    }

    /**
     * @param $action
     * @param $item
     * @return int
     */
    protected function setTimePostRequest($item, $action = 'init')
    {
        return $this->checkResponseRequest($this->{$action}($item));
    }

    /**
     * @param $response
     * @return int
     */
    public function checkResponseRequest($response)
    {
        if (!isset($response) || empty($response) || !is_object($response)) {
            return $response = Config::STATUS_RESPONSE_FAIL;
        }

        $content = $response->getBody()->getContents();
        $response = json_decode($content);

        if (isset($response->status) && $response->status == 'ok') {
            $response = Config::STATUS_RESPONSE_TRUE;
        }

        return $response;
    }

}