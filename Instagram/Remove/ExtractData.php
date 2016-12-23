<?php
namespace Instagram\Common;

class ExtractData_
{
    protected $decode;

    public function __construct($contentResponse, $scriptEx = '')
    {
        $this->decode = new DecodeData($contentResponse, $scriptEx);
    }

    public function extract(array $dataElements = ['media', 'top_posts'], $nameEleGet = '')
    {
        $data = [];
        try {
            $tag = $this->decode->getScriptDataIns()->entry_data->TagPage[0]->tag;
            foreach ($dataElements as $nameElement) {
                $data = array_merge($data, $this->buildDataIds($tag, $nameElement, $nameEleGet));
            }
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        return $data;
    }

    public function buildDataIds($data, $nameElement, $nameEleGet = '')
    {
        $result = [];
        $data = $data->{$nameElement};

        if (empty($data)) {
            new CurlException('Please confirm data param');
        }

        foreach ($data->nodes as $key => $item) {
            try {
                $res = $item->owner->id;
                if ($nameEleGet && property_exists($item, $nameEleGet)) {
                    $res = $item->{$nameEleGet};
                }
                array_push($result, $res);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $result;
    }

}