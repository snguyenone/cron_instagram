<?php
namespace Instagram\Type;

use Instagram\Common\CurlException;
use Instagram\Common\ExtractData;
use Instagram\DataMap;
use Instagram\Config;

class Tags extends Base
{
    /**
     * @var $dataTag
     */
    protected $tags = [];
    protected $dataTags = [];
    protected $mediaIds;
    protected $ownerIds;

    /**
     * @return mixed
     */
    public function getDataTag()
    {
        return $this->tag;
    }

    /**
     * @param $tag
     * @return $this
     */
    public function setDataTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get multi tags from Instagram
     *
     * @param $dataTag array or string has name tag for search Instagram
     * @param string $extractStr $extractStr used for implode if $dataTag is string
     * @return $this
     */
    public function getMultiTags($dataTag, $extractStr = '')
    {
        if (isset($this->dataResponse) && !empty($this->dataResponse)) {
            return $this;
        }

        if (gettype($dataTag) === 'string' && $extractStr) {
            if (strpos($extractStr, $dataTag) === false) {
                new CurlException('Please confirm string data tag.');
            }

            $dataTag = explode($extractStr, $dataTag);
        }

        if (!is_array($dataTag) || empty($dataTag)) {
            new CurlException('Data tag param must is a array.');
        }

        $this->getTag($this->setDataTag($dataTag)->getDataTag());

        return $this;
    }

    /**
     * Get response from a tag of Instagram
     *
     * @param array $dataTag
     * @return mixed
     * @internal param string $tagName
     */
    public function getTag(array $dataTag)
    {
        foreach ($dataTag as $tagName) {
            array_push($this->dataResponse, $this->get->getRequest(Config::insUrlTag() . urlencode($tagName)));
        }

        return $this;
    }

    /**
     * Export data : medias and owner id get from search list tag
     *
     * @return array
     */
    public function getData()
    {
        $this->mediaIds = isset($this->mediaIds) ? $this->mediaIds : $this->getDataIds(DataMap::CL_MEDIA);
        $this->ownerIds = isset($this->ownerIds) ? $this->ownerIds : $this->getDataIds(DataMap::CL_OWNER);
        $this->dataTags = $this->compare(array_merge($this->mediaIds, $this->ownerIds));

        return $this->dataTags;
    }

    /**
     * Export data : medias and owner id get from search list tag
     *
     * @return array
     */
    public function getCursorTags()
    {
        if (empty($this->cursorTags)) {
            new CurlException(__METHOD__);
        }

        return $this->cursorTags;
    }

    /**
     * Run load more data response from server
     *
     * @return array
     */
    public function loadMoreTags()
    {
        $result = [];
        $dataMedia = $this->dataTags[$this->mediasKey];
        $dataOwner = $this->dataTags[$this->ownersKey];
        $dataCheck = count($dataMedia) >= count($dataOwner) ? $dataOwner : $dataMedia;

        $dataCursor = $this->getCursorTags();

        if (count($this->getDataTag()) !== count($dataCursor) || empty($dataCursor)) {
            new CurlException(__METHOD__);
        }

        foreach ($dataCursor as $key => $cursor) {
            $param = $this->getParams($this->getDataTag()[$key], $cursor);
            if (!$this->obLoadMore->checkLoad($dataCheck, $param)) {
                return $this->dataTags;
            }

            $dataResponse = $this->obLoadMore->load();
            $ex = new ExtractData($dataResponse->getBody()->getContents());
            $result[] = $ex->extract(DataMap::MEDIA, $ex->getObjectDecode()->getScriptDataIns());
        }

        $this->dataTags[$this->mediasKey] = array_merge($this->compare($result)[$this->mediasKey], $this->dataTags[$this->mediasKey]);
        $this->dataTags[$this->ownersKey] = array_merge($this->compare($result)[$this->ownersKey], $this->dataTags[$this->ownersKey]);

        $this->loadMoreTags();

        return $this->dataTags;
    }

    /**
     * Compare data media or owner with param array check
     *
     * @param array $mediaData
     * @param array $ownerData
     * @return $this
     */
    public function compareDataTags($mediaData = [], $ownerData = [])
    {
        $this->dataTags[$this->mediasKey] = array_diff($this->dataTags[$this->mediasKey], $mediaData);
        $this->dataTags[$this->ownersKey] = array_diff($this->dataTags[$this->ownersKey], $ownerData);

        return $this;
    }

    /**
     * @param $tag
     * @param $cursor
     * @return array
     */
    protected function getParams($tag, $cursor)
    {
        return [
            'form_params' => Config::queryParams($tag, $cursor)
        ];
    }

}