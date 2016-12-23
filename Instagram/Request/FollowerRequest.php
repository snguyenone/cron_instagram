<?php
namespace Instagram\Request;

use Instagram\Config;

class FollowerRequest extends PostRequest
{
    protected $userId;

    /**
     * @param $userId
     * @return mixed
     */
    protected function init($userId)
    {
        return $this->postRequest(
            Config::insUrlFollower(),
            Config::queryParamsFollower($userId)
        );
    }

    /**
     * @param $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $cursor
     * @return int
     */
    public function follower($cursor = '')
    {
//        var_dump($this->getUserId(), Config::insUrlFollower(), Config::queryParamsFollower('4204336802', $cursor));
        return $this->postRequest(
            Config::insUrlFollower(),
            ['form_params' => Config::queryParamsFollower('4204336802', $cursor)]
        );
    }

    /**
     * @return int
     */
    public function firstReqFollower()
    {
        return $this->follower();
    }

    /**
     * @param $cursor
     * @return int
     */
    public function nextReqFollower($cursor)
    {
        return $this->follower($cursor);
    }

}