<?php
namespace Instagram\Common;

use Instagram\Config;
use Instagram\DataMap;

class ExtractData
{
    /**
     * @var $result : save result of extract
     */
    protected $result = [];

    /**
     * @var DecodeData
     */
    public $decode;

    /**
     * @var $dataEx
     */
    protected $dataEx;

    /**
     * ExtractData constructor.
     * @param $contentResponse
     * @param string $scriptEx
     */
    public function __construct($contentResponse, $scriptEx = '')
    {
        $this->decode = isset($this->decode) ? $this->decode : new DecodeData($contentResponse, $scriptEx);
    }

    /**
     * @return DecodeData
     */
    public function getDecode()
    {
        return $this->decode;
    }

    /**
     * @return mixed
     */
    public function getObjectDecode()
    {
        return (new CallObject())->getObjectName($this, 'decode');
    }

    /**
     * @param string $dataEx
     * @param bool $decodeArray
     * @return $this
     */
    public function getDataEx($dataEx = '', $decodeArray = false)
    {
        $result = $this->decode->getScriptDataIns($decodeArray);

        $this->dataEx = $dataEx ? $dataEx : ($decodeArray ? $result['entry_data']['TagPage'][0]['tag'] :
            $result->entry_data->TagPage[0]->tag);

        PrintData::preview(Config::CHECK_DATA_CONTENT_RESPONSE, __METHOD__, $this->dataEx);

        return $this;
    }

    /**
     * Extract data object as: json_decode()
     *
     * @param $nameNode
     * @param string $dataEx : object json
     * @param bool $decodeArray
     * @param array $dataMap
     * @return array
     */
    public function extract($nameNode, $dataEx = '', $decodeArray = true, array $dataMap = [])
    {
        $this->result = [];
        $this->getDataEx($dataEx, $decodeArray);
        $dataMap = empty($dataMap) ? DataMap::getDataMap() : $dataMap;

        foreach ($dataMap[$nameNode] as $key => $node) {
            if (!isset($this->dataEx[$nameNode][$node[0]])) {
                new CurlException(__METHOD__);
            }

            $nodeParent = $this->dataEx[$nameNode][$node[0]];

            if (empty($nodeParent) || !is_array($node) || empty($node)) {
                new CurlException(__METHOD__);
            }

            unset($node[0]);
            // Create path node of $nodeParent
            $decodeArray ? $this->getNodeArrayData($nameNode, $nodeParent, $node, $key) :
                $this->getNodeObjectData($nameNode, $nodeParent, $node, $key);
        }

        return $this->result[$nameNode];
    }

    /**
     * @param $parent
     * @param $nodeParent
     * @param $child
     * @param $key
     * @return $this
     */

    protected function getNodeArrayData($parent, $nodeParent, $child, $key)
    {
        foreach ($nodeParent as $item) {
            switch (count($child)) {
                case 2:
                    $node = $item[$child[1]][$child[2]];
                    break;
                case 3:
                    $node = $item[$child[1]][$child[2]][$child[3]];
                    break;
                case 4:
                    $node = $item[$child[1]][$child[2]][$child[3]][$child[4]];
                    break;
                case 5:
                    $node = $item[$child[1]][$child[2]][$child[3]][$child[4]][$child[5]];
                    break;
                case 6:
                    $node = $item[$child[1]][$child[2]][$child[3]][$child[4]][$child[5]][$child[6]];
                    break;
                default:
                    $node = $this->checkArrayForGetElement($item, $child[1]);
                    break;
            }

            $this->setResult($parent, $key, $node);
        }

        return $this;
    }

    /**
     * @param $parent
     * @param $nodeParent
     * @param $child
     * @param $key
     * @return $this
     */
    protected function getNodeObjectData($parent, $nodeParent, $child, $key)
    {
        foreach ($nodeParent as $item) {
            switch (count($child)) {
                case 2:
                    $node = $item->$child[1]->$child[2];
                    break;
                case 3:
                    $node = $item->$child[1]->$child[2]->$child[3];
                    break;
                case 4:
                    $node = $item->$child[1]->$child[2]->$child[3]->$child[4];
                    break;
                case 5:
                    $node = $item->$child[1]->$child[2]->$child[3]->$child[4]->$child[5];
                    break;
                case 6:
                    $node = $item->$child[1]->$child[2]->$child[3]->$child[4]->$child[5]->$child[6];
                    break;
                default:
                    $node = $this->checkArrayForGetElement($item, $child[1]);
                    break;
            }

            $this->setResult($parent, $key, $node);
        }

        return $this;
    }

    public function setResult($parent, $key, $value)
    {
        try {
            $this->result[$parent][$key][] = $value;
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }
    }

    /**
     * Get data element result data after extract
     * note $nameEle must is constant of "DataMap"
     *
     * @param $nameEle
     * @return mixed
     */

    public function getEleResultEx($nameEle)
    {
        if (!isset($this->result[$nameEle])) {
            new CurlException($nameEle . ' must is constant of "DataMap".');
        }

        return isset($this->result[$nameEle]) ? $this->result[$nameEle] : $nameEle;
    }

    /**
     * Get data element result data after extract
     * note $nameEle must is constant of "DataMap"
     *
     * @param array $data
     * @param $nameEle
     * @return mixed
     */

    protected function checkArrayForGetElement($data, $nameEle)
    {
        return is_array($data) && isset($data[$nameEle]) ? $data[$nameEle] : $data;
    }

    /**
     * @param $data
     * @param $element
     * @return bool
     */
    public function checkObjectElement($data, $element)
    {
        return isset($data->$element) ? $data->$element : false;
    }

    /**
     * @return DecodeData
     */
    public function getContentDecode()
    {
        return $this->decode;
    }


}