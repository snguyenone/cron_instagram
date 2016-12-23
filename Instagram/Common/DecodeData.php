<?php
namespace Instagram\Common;

use Instagram\Config;

class DecodeData
{
    /**
     * @var string $content string response from server
     */
    protected $content;

    /**
     * @var object $dataInstagram save object parse content response server
     */
    protected $dataInstagram;

    /**
     * Save data after decode from data response of server
     *
     * @var $dataDecode array
     */
    protected $dataDecode;

    /**
     * @var string $scriptEx script for parse data response from server
     */
    protected $scriptEx;

    /**
     * DecodeData constructor.
     * @param $contentResponse
     * @param string $scriptEx
     */
    public function __construct($contentResponse, $scriptEx = '')
    {
        $this->content = $contentResponse;
        $this->scriptEx = $scriptEx;
    }

    /**
     * @param bool $resArray
     * @return mixed
     */
    public function getScriptDataIns($resArray = true)
    {
        $this->scriptEx = $this->scriptEx ? $this->scriptEx : '/<script\b[^>]*>window._sharedData\s*=([\s\S]*?)\;<\/script>/';

        try {
            preg_match($this->scriptEx, $this->getContent(), $this->dataInstagram);
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        if (empty($this->dataInstagram)) {
            return $this->decode($this->getContent(), $resArray);
        }

        if (!isset($this->dataInstagram[1])) {
            new CurlException('Please confirm dataIns after preg_match.'.__METHOD__);
        }

        PrintData::preview(Config::CHECK_DATA_CONTENT_RESPONSE, __METHOD__, json_decode($this->dataInstagram[1], $resArray));

        return $this->decode($this->dataInstagram[1], $resArray);
    }

    /**
     * @param $nameElement
     * @return mixed
     */
    public function getElementIns($nameElement)
    {
        return $this->getScriptDataIns()->{$nameElement};
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $dataDecode
     * @param bool $resArray
     * @return mixed
     */
    public function decode($dataDecode, $resArray = true)
    {
        return $this->dataDecode = json_decode($dataDecode, $resArray);
    }

}