<?php
namespace Instagram\Data;

use Instagram\Common\ExtractData;

abstract class DataBase implements DataInterface
{
    protected $extract;

    /**
     * MediaIds constructor.
     * @param $contentResponse
     */
    public function __construct($contentResponse)
    {
        $this->extract = new ExtractData($contentResponse);
    }

    /**
     * @return ExtractData
     */
    public function getExtract()
    {
        return $this->extract;
    }

    /**
     * @param string $name
     * @return array
     */
    public function init($name = '')
    {
        $name = $name ? $name : $this->name;
        return $this->getExtract()->extract($name);
    }

}