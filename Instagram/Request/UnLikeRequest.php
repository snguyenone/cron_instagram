<?php
namespace Instagram\Request;

use Instagram\Config;

class UnLikeRequest extends PostRequest
{
    /**
     * @param $mediaId
     * @return mixed
     */
    protected function init($mediaId)
    {
        return $this->postRequest(str_replace(Config::CONST_LIKE, $mediaId, Config::insUrlUnLike()));
    }

    /**
     * @param $mediaId
     * @return mixed
     */
    public function unLike($mediaId)
    {
        return $this->setTimePostRequest($mediaId);
    }

    /**
     * @param array $dataMediaIds
     */
    public function unlikeMulti(array $dataMediaIds)
    {
       $this->setTimePostRequest($dataMediaIds, 'unLike');
    }

}