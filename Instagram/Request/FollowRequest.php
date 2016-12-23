<?php
namespace Instagram\Request;

use Instagram\Config;

class FollowRequest extends PostRequest
{
    /**
     * @param $userId
     * @return mixed
     */
    protected function init($userId)
    {
       return $this->postRequest(str_replace(Config::CONST_FOLLOW, $userId, Config::insUrlFollow()));
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function follow($userId)
    {
        return $this->setTimePostRequest($userId);
    }

    /**
     * @param array $dataUserIds
     */
    public function followMulti(array $dataUserIds)
    {
        $this->setTimePostRequest($dataUserIds, 'follow');
    }


}