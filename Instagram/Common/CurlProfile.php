<?php
namespace Instagram\Common;

use Instagram\Config;
use Instagram\DataMap;
use Instagram\Request\GetRequest;

class CurlProfile
{
    /**
     * @var array $profile
     */
    protected $profile;

    /**
     * CurlProfile constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->getRequest = isset($this->getRequest) ? $this->getRequest : new GetRequest($client);
    }

    /**
     * @param $userName
     * @return $this
     */
    public function setProfile($userName)
    {
        $response = $this->getRequest->getRequest(Config::insUrlProfile() . $userName);

        if (!isset($response) || empty($response)) {
            $this->profile = [];
            return $this;
        }

        $ex = new ExtractData($this->getRequest->getContent());
        $this->profile = $ex->extract(DataMap::ENTRY_DATA, $ex->getDecode()->getScriptDataIns(true));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @return GetRequest
     */
    public function getRequest()
    {
        return $this->getRequest;
    }

}