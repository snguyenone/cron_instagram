<?php
namespace Instagram\Request;

use Instagram\Config;
use Instagram\Common\CurlException;

class MoreRequest extends PostRequest
{
    /**
     * @var $dataCheck array for check is send or not send request
     */
    protected $dataCheck;

    /**
     * @var $dataParams array is params list conditions for send request to server
     */
    protected $dataParams;

    /**
     * Run load more data from server
     *
     * @param array $dataParams
     * @param array $dataCheck
     * @return array
     */

    public function checkLoad(array $dataCheck, array $dataParams)
    {
        if (empty($dataCheck) || empty($dataParams)) {
            new CurlException(__METHOD__);
        }

        $check = true;
        $this->setDataCheck($dataCheck);
        $this->dataParams = $dataParams;

        try {
            $count = count($this->getDataCheck());
            if ($count > Config::CONFIG_NUMBER_MAX_TAGS * Config::CONFIG_MAX_NUMBER_REQUEST) {
                $check = false;
            }
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        return $check;
    }

    /**
     * Set value data check for action request more
     *
     * @param array $dataCheck
     * @return $this
     */
    protected function setDataCheck(array $dataCheck)
    {
        $this->dataCheck = $dataCheck;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataCheck()
    {
        return $this->dataCheck;
    }

    /**
     * Send query with params to server load
     * @return object response
     */
    public function load()
    {
        return $this->postRequest(Config::insUrlQuery(), $this->dataParams);
    }

}