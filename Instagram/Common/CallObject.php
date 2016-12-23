<?php
namespace Instagram\Common;

class CallObject
{
    /**
     * @var $class : name class call data
     */
    protected $class;

    /**
     * CallObjectData constructor.
     * @param string $className must path namespace to class name
     * @param string $contentResponse this string data response
     */
    public function __construct($className = '', $contentResponse = '')
    {
        if (empty($className) || empty($contentResponse)) {
            return $this;
        }

        try {
            $this->class = new $className($contentResponse);
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param $object
     * @param $nameObj
     * @return mixed
     */
    public function getObjectName($object, $nameObj)
    {
        if (!property_exists($object, $nameObj)) {
            new CurlException(__METHOD__ . ' property object not exists.');
        }

        return $object->{$nameObj};
    }

}