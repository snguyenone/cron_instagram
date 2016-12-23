<?php
namespace Instagram\Common;

class CompareData
{
    /**
     * @param array $data
     * @param $key
     * @param $item
     * @return array
     */
    public function compare(array $data, $key, $item)
    {
        $result = [];

        if (empty($data)) {
            new CurlException(__METHOD__);
        }

        foreach ($data as $value) {
            $result[$key] = isset($result[$key]) ? array_merge($result[$key], $value[$item]) : $value[$item];
        }

        return $result;
    }

}