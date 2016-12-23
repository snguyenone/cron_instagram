<?php
namespace Instagram;

class BaseIns
{
    protected $content;
    protected $dataIns;
    protected $scriptEx;

    public function __construct($contentResponse, $scriptEx = '')
    {
        $this->content  = $contentResponse;
        $this->scriptEx = $scriptEx;
    }

    protected function getScriptDataIns()
    {
        $this->scriptEx = $this->scriptEx ? $this->scriptEx : '/<script\b[^>]*>window._sharedData\s*=([\s\S]*?)\;<\/script>/';

        try {
            preg_match($this->scriptEx, $this->content, $this->dataIns);
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        if (!isset($this->dataIns[1])) {
            new CurlException('Please confirm dataIns after preg_match.');
        }

        return json_decode($this->dataIns[1]);
    }

    public function getElementIns($nameElement)
    {
        return $this->getScriptDataIns()->{$nameElement};
    }

    public function getContentIns()
    {
        return $this->content;
    }
}