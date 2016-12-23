<?php
namespace Instagram\Request;

use Instagram\Config;

class UnFollowRequest extends PostRequest
{
    /**
     * @param $userId
     * @return mixed
     */
    protected function init($userId)
    {
       return $this->postRequest(str_replace(Config::CONST_FOLLOW, $userId, Config::insUrlUnFollow()));
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function unFollow($userId)
    {
        return $this->setTimePostRequest($userId);
    }

    /**
     * @param $action
     * @param $item
     * @return int
     */
    protected function setTimePostRequest($item, $action = 'init')
    {
        $response = $this->{$action}($item);

        \Log::info(__METHOD__.json_encode($response));

        if (!isset($response) || !is_object($response) || empty($response)) {
            return $response = Config::STATUS_RESPONSE_FAIL;
        }

        $content = $response->getBody()->getContents();
        $response = json_decode($content);

        if (isset($response->status) && $response->status == 'ok') {
            $response = Config::STATUS_RESPONSE_TRUE;
        }

        return $response;
    }

    /**
     * @param array $dataUserIds
     */
    public function followMulti(array $dataUserIds)
    {
        $this->setTimePostRequest($dataUserIds, 'unFollow');
    }

}