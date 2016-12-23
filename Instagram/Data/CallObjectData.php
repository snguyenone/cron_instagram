<?php
namespace Instagram\Data;

use Instagram\Common\CallObject;

class CallObjectData extends CallObject
{
    /**
     * CallObjectData constructor.
     * @param $className
     * @param $contentResponse
     */
    public function __construct($className, $contentResponse)
    {
        $className = 'Instagram\\Data\\' . $className;
        parent::__construct($className, $contentResponse);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->getClass()->init();
    }

}