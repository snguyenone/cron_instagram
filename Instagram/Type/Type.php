<?php
namespace Instagram\Type;

use Instagram\Common\ExtractData;
use Instagram\Config;
use Instagram\DataMap;

class Type
{
    protected $data;
    protected $type;
    protected $typeObject;
    protected $numberRunRequest;
    protected $numberForARequest;
    protected $response;

    /**
     * Followers constructor.
     * @param $numberForARequest
     * @param $client
     */
    public function __construct($client, $numberForARequest = 1000)
    {
        $this->numberForARequest = $numberForARequest;
        $this->typeObject = isset($this->typeObject) ? $this->typeObject : $client;
    }

    /**
     * @param $userId
     * @param $response
     * @return $this
     * @internal param $userName
     */
    public function getData($userId, $response)
    {
        $checkResponse = $this->typeObject->setUserId($userId)->checkResponseRequest($response);

        if ($checkResponse === Config::STATUS_RESPONSE_FAIL) {
            $this->data = [];
            return $this;
        }

        $ex = new ExtractData($response->getContent());
        $this->data = $ex->extract(
            DataMap::ENTRY_FOLLOWER,
            $ex->getDecode()->getScriptDataIns(true)
        );

        return $this->data;
    }

    /**
     * @param $userId
     * @return array
     */
    public function requestMore($userId)
    {
        $response      = [];
        $nextFunction  = 'nextReq' . ucfirst($this->type);
        $responseFirst = $this->firstRequest($userId);
        $cursor        = $responseFirst->end_cursor;
        $number        = $this->getNumberRequest();
        $response[]    = $responseFirst;

        if ($number <= 1) {
            return $response;
        }

        foreach ($number as $n) {
            $nextReq  = $this->getData($userId, $this->typeObject->$nextFunction($cursor));
            $cursor   = $nextReq->end_cursor;
            $response[] = $nextReq;
        }

        return $response;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function firstRequest($userId)
    {
        $firstFunction = 'firstReq' . ucfirst($this->type);
        var_dump($this->typeObject->$firstFunction());die;
        return $this->getData($userId, $this->typeObject->$firstFunction());
    }

    /**
     * @param $totalNeedRunRequest
     * @return $this
     */
    protected function setNumberRequest($totalNeedRunRequest)
    {
        $number = ceil($totalNeedRunRequest / $this->numberForARequest);
        $this->numberRunRequest = $number == 0 ? 1 : $number;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getNumberRequest()
    {
        return $this->numberRunRequest;
    }
}