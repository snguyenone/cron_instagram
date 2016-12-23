<?php
namespace Instagram\Request;

use Instagram\Config;

class LikeRequest extends PostRequest
{
    /**
     * @param $mediaId
     * @return mixed
     */
    protected function init($mediaId)
    {
        return $this->postRequest(str_replace(Config::CONST_LIKE, $mediaId, Config::insUrlLike()));
    }

    /**
     * @param $mediaId
     * @return mixed
     */
    public function like($mediaId)
    {
        return $this->setTimePostRequest($mediaId);
    }

    /**
     * @param array $dataMediaIds
     */
    public function likeMulti(array $dataMediaIds)
    {
       $this->setTimePostRequest($dataMediaIds, 'like');
    }

}