<?php
namespace Instagram\Request;

use Mockery\CountValidator\Exception;

class GetRequest extends Request
{
    /**
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function getRequest($uri, array $options = [])
    {
        return $this->sendRequest('get', $uri, $options);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        try{
            return $this->getResponse()->getBody()->getContents();
        }catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}