<?php
namespace Instagram;

class Config
{
    /**
     * Config set enable log for debug
     */
    const SET_VIEW_LOG = true;

    /**
     * Config has use hash password user
     */
    const SET_HASH_GUEST_PASSWORD = true;

    /**
     * Max number for user has run follow, when number user follow = MAX_NUMBER_HAS_FOLLOW_OF_A_USER
     * then user will run follow and liked after NUMBER_DATES_SEND_REQUEST_FOR_USER_MAX_FOLLOW days
     */
    const MAX_NUMBER_HAS_FOLLOW_OF_A_USER = 3000;

    /**
     * Number days send request for a user is max follow = MAX_NUMBER_HAS_FOLLOW_OF_A_USER
     */
    const NUMBER_DATES_SEND_REQUEST_FOR_USER_MAX_FOLLOW = 5;

    /**
     * Config max request of number can send to server in date
     */
    const CONFIG_MAX_REQUEST_OF_USER_SEND_IN_DATE = 200;

    /**
     * Config max request of number can follow in date
     */
    const CONFIG_MAX_REQUEST_OF_USER_SEND_FOLLOW_IN_DATE = 200;

    /**
     * Config max request of number can like in date
     */
    const CONFIG_MAX_REQUEST_OF_USER_SEND_LIKE_IN_DATE = 600;

    /**
     * Config max number request fail of user to server => check user has blocked
     */
    const CONFIG_MAX_NUMBER_REQUEST_FAIL_OF_USER = 4;

    /**
     * Set date for action run unlike and unfollow
     */
    const DATE_CALL_SEND_REQUEST_UN_LIKE_FOLLOW = 3;

    /**
     * Constant for like request
     */
    const CONST_LIKE = '#mediaId#';

    /**
     * Constant for follow request
     */
    const CONST_FOLLOW = '#userId#';

    /**
     * Path server name
     */
    const BASE_URL = 'https://www.instagram.com/';

    /**
     * Set max number per user can send request as follow, like ...
     */
    const MAX_NUMBER_ACTION = 100;

    /**
     * Set number create a array per 1 send request action as 5 like + 5 follow..
     */
    const CONFIG_LENGTH_SEND_REQUEST = 5;

    /**
     * Config number git limit row for show data in screen view
     */
    const CONFIG_NUMBER_GET_LIMIT_ROWS = 63;

    /**
     * Number max tags
     */
    const CONFIG_NUMBER_MAX_USER = 2;

    /**
     * Number max tags
     */
    const CONFIG_NUMBER_MAX_TAGS = 2;

    /**
     * Set max for action send request as un follow, like
     */
    const CONFIG_MAX_NUMBER_REQUEST_UN_LINE_FOLLOW = 10;

    /**
     * Set max number per user can send request as follow, like from server...
     */
    const CONFIG_MAX_NUMBER_REQUEST = 5;

    /**
     * Set number for a load more data from server
     */
    const CONFIG_NUMBER_QUERY_LOAD_MORE = 20;

    /**
     * Set time(number second) sleep between 2 request send to sever
     */
    const CONFIG_TIME_SLEEP_BETWEEN_TWO_REQUEST = 3;

    /**
     * Set config number minutes send callback request
     * Has 4 parameters for minute : 1, 5, 10, 30 ... default set = 10
     */
    const MINUTES_CALLBACK_REQUEST = 5;

    /**
     * Set number minute callback unfollow request
     */
    const MINUTES_CALLBACK_UN_FOLLOW_REQUEST = 2;

    /**
     * Set config number minutes send request to server
     * Has 4 parameters for minute : 1, 5, 10, 30 ... default set = 10
     */
    const MINUTES_CALL_SEND_REQUEST_LIKE_FOLLOW = 1;

    /**
     * Set time send request to server for unlike and unfollow
     */
    const MINUTES_CALL_SEND_REQUEST_UN_LIKE_FOLLOW = 2;

    /**
     * Set time send request to server for unfollow
     */
    const MINUTES_CALL_SEND_REQUEST_UN_FOLLOW = 3;

    /**
     * Set time send request to server for unlike
     */
    const MINUTES_CALL_SEND_REQUEST_UN_LIKE = 2;

    /**
     * Set response status response from server to fail
     */
    const STATUS_RESPONSE_FAIL = 403;

    /**
     * Set response status response from server to true
     */
    const STATUS_RESPONSE_TRUE = 200;

    /**
     * Number for number max request fail of 1 media_id or owner_id
     */
    const MAX_NUMBER_REQUEST_FAIL = 2;

    /**
     * MAX_NUMBER_REQUEST_FOR_GET_DATA_FOLLOWER
     */
    const MAX_NUMBER_REQUEST_FOR_GET_DATA_FOLLOWER = 1000;

    /**
     * Set response STATUS RESPONSE FAIL
     */
    const CHECK_DATA_CONTENT_RESPONSE = false;

    /**
     * Path action send request login
     */
    public static function insUrlLogin()
    {
        return self::BASE_URL . 'accounts/login/ajax/';
    }

    /**
     * Path action send get tag request
     */
    public static function insUrlTag()
    {
        return self::BASE_URL . 'explore/tags/';
    }

    /**
     * Path view a media get a tags
     */
    public static function insUrlViewAMedia()
    {
        return self::BASE_URL . 'p/';
    }

    /**
     * Path action send like request
     */
    public static function insUrlLike()
    {
        return self::BASE_URL . 'web/likes/' . self::CONST_LIKE . '/like/';
    }

    /**
     * Path action send like request
     */
    public static function insUrlUnLike()
    {
        return self::BASE_URL . 'web/likes/' . self::CONST_LIKE . '/unlike/';
    }

    /**
     * Path action send follow request
     */
    public static function insUrlFollow()
    {
        return self::BASE_URL . 'web/friendships/' . self::CONST_FOLLOW . '/follow/';
    }

    /**
     * Path action send follow request
     */
    public static function insUrlFollower()
    {
        return self::BASE_URL . 'query';
    }

    /**
     * Path action send follow request
     */
    public static function insUrlUnFollow()
    {
        return self::BASE_URL . 'web/friendships/' . self::CONST_FOLLOW . '/unfollow/';
    }

    /**
     * Path action send follow request follow, like, unlike, unfollow
     *
     * @param $code string is code of a image
     * @return string
     */
    public static function insUrlPathGetCookiesForUserAction($code)
    {
        return self::BASE_URL . 'p/'.$code;
    }

    /**
     * Path action send query request
     */
    public static function insUrlQuery()
    {
        return self::BASE_URL . 'query';
    }

    /**
     * Path action send query request
     */
    public static function insUrlProfile()
    {
        return self::BASE_URL;
    }

    /**
     * Path action send query request
     */
    public static function insUrlRegister()
    {
        return self::BASE_URL;
    }

    /**
     * Path action send query request
     */
    public static function insUrlResetPassword()
    {
        return self::BASE_URL.'accounts/password/reset/';
    }

    /**
     * Render number sleep between two request send to server
     *
     * @param int $minNumber
     * @param int $maxNumber
     * @return int
     */
    public static function getNumberRandomSleepRequest($minNumber = 3, $maxNumber = 5)
    {
        return random_int($minNumber, $maxNumber);
    }

    /**
     * Set config params send tag request
     *
     * @param $tag
     * @param $cursor
     * @return array
     */
    public static function queryParams($tag, $cursor)
    {
        return [
            'q' => 'ig_hashtag(' . $tag . ') { media.after(' . $cursor . ', ' . self::CONFIG_NUMBER_QUERY_LOAD_MORE . ') {
                 count,
                 nodes {
                     caption,
                     code,
                     comments {
                       count
                     },
                     comments_disabled,
                     date,
                     dimensions {
                       height,
                       width
                     },
                     display_src,
                     id,
                     is_video,
                     likes {
                       count
                     },
                     owner {
                       id
                     },
                     thumbnail_src,
                     video_views
                 },
                 page_info
                }
              }',
            'ref' => 'tags::show'
        ];
    }

    /**
     * Set config params get data follower of a user
     *
     * @param $cursors
     * @param $userId
     * @return array
     */
    public static function queryParamsFollower($userId, $cursors = '')
    {
        $cursors = empty($cursors) ? 'followed_by.first(' . self::MAX_NUMBER_REQUEST_FOR_GET_DATA_FOLLOWER . ') ' :
            ' follows.after('.$cursors.', '.self::MAX_NUMBER_REQUEST_FOR_GET_DATA_FOLLOWER .') ';

        return [
            'q' => 'ig_user('.$userId.') {  
                 '.$cursors.' {   
                         count,     
                         page_info {       
                           end_cursor,
                           has_next_page     
                         },     
                         nodes { 
                           id,       
                           is_verified,       
                           followed_by_viewer,       
                           requested_by_viewer,      
                           full_name,       
                           profile_pic_url,      
                           username     
                         }             
                 } 
            }',
            'ref' => 'relationships::follow_list'
        ];
    }

}