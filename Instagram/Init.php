<?php
namespace Instagram;

use App\Models\Base;
use App\Models\Media;
use App\Models\Owner;
use App\Models\User;
use GuzzleHttp\Client;
use Instagram\Common\CallObject;
use Instagram\Common\ClientAction;
use Instagram\Common\CompareData;
use Instagram\Common\CurlCookiesJar;
use Instagram\Common\CurlException;
use Instagram\Common\CurlHeader;
use Instagram\Common\CurlProfile;
use Instagram\Request\FollowRequest;
use Instagram\Request\GetRequest;
use Instagram\Request\LikeRequest;
use Instagram\Request\UnFollowRequest;
use Instagram\Request\UnLikeRequest;
use Instagram\Type\Followers;
use Instagram\Type\Tags;
use League\Flysystem\Exception;

class Init
{
    /**
     * @var Client
     */
    protected $client;
    protected $cookieJaUser;

    /**
     * @var CompareData
     */
    protected $compare;

    /**
     * @var $objTag
     */
    public $objTag;

    /**
     * @var object $likeObject
     */
    public $likeObject;

    /**
     * @var object $followObject
     */
    public $followObject;

    /**
     * Init constructor.
     * @param $loginRes
     * @param array $userInfo
     * @throws Exception
     */
    public function __construct($loginRes, $userInfo = [])
    {
        try {
            $this->compare = isset($this->compare) ? $this->compare : new CompareData();
            $this->client  = new Client((new CurlHeader($loginRes->getCookieJarLogin()))->getHeaderOptions());

            if ($this->checkUserExists($userInfo)) {
                $this->objTag = isset($this->objTag) ? $this->objTag : (new Tags($this->client));
                return $this;
            }

            $this->client = [];
            $this->updateUserActivePan($userInfo);

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $this;
    }

    /**
     * @param array $userInfo
     * @return bool
     */
    public function checkUserExists($userInfo = [])
    {
        $result = true;
        if (empty($userInfo) || !isset($userInfo[User::USER_NAME]) || !isset($userInfo[User::USER_ID])) {
            return $result;
        }

        if (empty($this->getProfile($userInfo[User::USER_NAME]))) {
            $result = false;
        }

        return $result;
    }

    /**
     * @param $userInfo
     * @return $this
     */
    protected function updateUserActivePan($userInfo)
    {
        if (!empty($this->getProfile($userInfo[User::USER_NAME]))) {
            return $this;
        }
        $userId = $userInfo[User::USER_ID];
        $this->userObject = isset($this->userObject) ? $this->userObject : new User();

        if ($this->userObject->find($userId)->update([User::USER_ACTIVE => User::CONSTANT_USER_PAN])) {
            $this->userObject->deleteUserConnectionUser($userId, [new Media(), new Owner()]);
        }

        return $this;
    }

    /**
     * @param array $dataTag
     * @return object
     */
    public function tagsResponse(array $dataTag = [])
    {
        return $this->objTag->getMultiTags($dataTag);
    }

    /**
     * Check action load more
     *
     * @param $dataTags
     * @param array $mediaData
     * @param array $ownerData
     * @return array
     */
    public function tagsLoadMore($dataTags, $mediaData = [], $ownerData = [])
    {
        $this->tagsResponse($dataTags)->getData();
        $dataLoad = $this->objTag->compareDataTags($mediaData, $ownerData)->loadMoreTags();

        return $dataLoad;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $nameObj
     * @return mixed
     */
    public function getObjectName($nameObj)
    {
        return (new CallObject())->getObjectName($this, $nameObj);
    }

    /**
     * Call function request like media
     *
     * @param $mediaId
     * @return mixed
     */
    public function like($mediaId)
    {
        $this->likeObject = isset($this->likeObject)
            ? $this->likeObject
            : new LikeRequest($this->client);
        return $this->likeObject->like($mediaId);
    }

    /**
     * Call function request unlike media
     *
     * @param $mediaId
     * @return mixed
     */
    public function unLike($mediaId)
    {
        $this->unLikeObject = isset($this->unLikeObject)
            ? $this->unLikeObject
            : new UnLikeRequest($this->client);
        return $this->unLikeObject->unLike($mediaId);
    }

    /**
     * Call function request follow user
     *
     * @param $ownerId
     * @return mixed
     */
    public function follow($ownerId)
    {
        $this->followObject = isset($this->followObject)
            ? $this->followObject
            : new FollowRequest($this->client);
        return $this->followObject->follow($ownerId);
    }

    /**
     * Call function request follow user
     *
     * @param $userId
     * @return mixed
     */
    public function dataFollower($userId)
    {
        $this->follower = isset($this->follower)
            ? $this->follower
            : new Followers($this->client);
        return $this->follower->firstRequest($userId);
    }

    /**
     * Call function request unfollow user
     *
     * @param $ownerId
     * @param $code
     * @return mixed
     */
    public function unFollow($ownerId, $code)
    {
        $this->unfollowObject = isset($this->unfollowObject)
            ? $this->unfollowObject
            : new UnFollowRequest($this->client);
        return $this->unfollowObject->unFollow($ownerId);
    }

    /**
     * @param $userName
     * @return CurlProfile
     */
    public function getProfile($userName)
    {
        $this->profile = isset($this->profile) ? $this->profile : new CurlProfile($this->client);
        $profile = $this->profile->setProfile($userName)->getProfile();

        Base::writeLog(__METHOD__.json_encode($profile));

        if (empty($profile) || !isset($profile[DataMap::KEY_NOTE_PROFILE][0])) {
            Base::writeLog(__METHOD__.' GET FAILS PROFILES '.json_encode($profile));
            return $profile;
        }

        return $profile[DataMap::KEY_NOTE_PROFILE][0];
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function getRequest($url, $params = [])
    {
        return (new GetRequest($this->client))->getRequest($url, $params);
    }

    /**
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function getRequestStatus($url, $params = [])
    {
        return $this->getRequest($url, $params)->getStatusCode();
    }

    /**
     * @param $cookieJarUser
     * @return $this
     */
    protected function setCookieJarUser($cookieJarUser)
    {
        $this->cookieJaUser = $cookieJarUser;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getCookieJarUser()
    {
        return $this->cookieJaUser;
    }

    /**
     * Get Cookie Jar for user action as: like, follow, unfollow, unlike
     *
     * @param $code string code of a image user instagram
     * @return Client
     */
    public function getClientAction($loginRes)
    {
        $tes = new CurlHeader($loginRes->getCookieJarLogin());
        return (new ClientAction(Config::insUrlProfile().'/dog_and_sea.yoshimi'))->getCookieJarForAction($tes);
    }

}