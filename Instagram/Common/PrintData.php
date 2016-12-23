<?php
namespace Instagram\Common;

class PrintData
{
    public static function preview($condition, $object, $data)
    {
        if (!$condition) {
            return false;
        }

        $data[$object] = $data;
        echo '<pre>';
        var_dump($data);

        return true;
    }
}