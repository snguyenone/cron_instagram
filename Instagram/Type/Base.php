<?php
namespace Instagram\Type;

use Instagram\Data;
use Instagram\Common\CurlException;
use Instagram\Data\CallObjectData;
use Instagram\DataMap;
use Instagram\Request\GetRequest;
use Instagram\Common\CompareData;
use Instagram\Request\MoreRequest;

abstract class Base
{
    protected $get;
    protected $compare;
    protected $obLoadMore;
    protected $dataIds = [];
    protected $dataResponse = [];
    protected $contentResponse = [];
    protected $cursorTags = [];
    protected $resLoadMoreData;
    protected $dataCompare;

    /**
     * Base constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->mediasKey = DataMap::KEY_NOTE_MEDIA;
        $this->ownersKey = DataMap::KEY_NOTE_OWNER;

        $this->get          = isset($this->get) ? $this->get : new GetRequest($client);
        $this->obLoadMore   = isset($this->obLoadMore) ? $this->obLoadMore : new MoreRequest($client);
        $this->compare      = isset($this->compare) ? $this->compare : new CompareData();
    }

    /**
     * @param $className
     * @return array
     */
    public function getDataIds($className)
    {
        $this->dataIds = [];

        foreach ($this->getContentMultiTag() as $content) {
            array_push($this->dataIds, (new CallObjectData(ucfirst($className), $content))->getData());
        }

        return $this->dataIds;
    }

    /**
     * Get all content from tags
     *
     * @return array
     */
    public function getContentMultiTag()
    {
        if (empty($this->dataResponse) || !is_array($this->dataResponse)) {
            new CurlException('$dataResponse can not empty.');
        }

        foreach ($this->dataResponse as $key => $response) {
            $this->contentResponse[$key] = isset($this->contentResponse[$key])
                ? $this->contentResponse[$key]
                : $response->getBody()->getContents();
        }

        return $this->contentResponse;
    }

    /**
     * Compare data to final array
     *
     * @param array $data
     * @return array
     */
    protected function compare(array $data)
    {
        $this->dataCompare = $this->cursorTags = [];

        foreach ($data as $key => $value) {
            if (isset($value[DataMap::KEY_NOTE_CURSOR]) && !in_array($value[DataMap::KEY_NOTE_CURSOR][2], $this->cursorTags)) {
                $this->cursorTags[] = $value[DataMap::KEY_NOTE_CURSOR][2];
            }

            foreach (DataMap::$dataMapCompare as $key) {
                $this->checkCompareMerge($key, $value);
            }
        }

        return $this->dataCompare;
    }

    /**
     * @param $key
     * @param $item
     * @return $this
     */
    protected function checkCompareMerge($key, $item)
    {
        $this->dataCompare[$key] = isset($this->dataCompare[$key]) ?
            array_merge($this->dataCompare[$key], $item[$key]) : $item[$key];

        return $this;
    }

    /**
     * @return bool
     */
    protected function loadMoreData()
    {
        $dataCheck = self::getData();
        $params = self::getParams();

        if (!$this->obLoadMore->checkLoad($dataCheck, $params)) {
            return false;
        }

        $this->resLoadMoreData = $this->obLoadMore->load();

        return true;
    }

    /**
     * @param array $arrMerge
     * @return array
     */
    protected function merge(array $arrMerge)
    {
        $result = [];
        foreach ($arrMerge as $merge) {
            $result = array_merge($result, $merge);
        }

        return $result;
    }

}