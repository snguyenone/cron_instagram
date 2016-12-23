<?php
namespace Instagram;

class DataMap
{
    const CL_OWNER = 'OwnerIds';
    const CL_MEDIA = 'MediaIds';
    const CL_THUMB = 'ThumbImg';

    const ENTRY_FOLLOWER   = 'nodes';
    const ENTRY_DATA    = 'entry_data';
    const MEDIA         = 'media';
    const TOP_POSTS     = 'top_posts';

    const KEY_NOTE_MEDIA     = 'media_id';
    const KEY_NOTE_OWNER     = 'owner_id';
    const KEY_NOTE_CURSOR    = 'end_cursor';
    const KEY_NOTE_IMG_THUMB = 'img_thumb';
    const KEY_NOTE_CODE      = 'code';
    const KEY_NOTE_PROFILE   = 'profile';
    const NAME_TAG           = 'name';

    /**
     * @var array this is array for map path element object extract ...
     */
    public static $dataMap = [
        self::ENTRY_DATA => [
            self::KEY_NOTE_PROFILE => ['ProfilePage', 'user']
        ],
        self::ENTRY_FOLLOWER => [
            self::KEY_NOTE_PROFILE => []
        ],
        self::MEDIA => [
            self::KEY_NOTE_CURSOR => ['page_info', 'end_cursor'],
            self::KEY_NOTE_CODE => ['nodes', 'code'],
            self::KEY_NOTE_IMG_THUMB => ['nodes', 'thumbnail_src'],
            self::KEY_NOTE_MEDIA => ['nodes', 'id'],
            self::KEY_NOTE_OWNER => ['nodes', 'owner', 'id'],
        ],
        self::TOP_POSTS => [
            self::KEY_NOTE_IMG_THUMB => ['nodes', 'thumbnail_src'],
            self::KEY_NOTE_CODE => ['nodes', 'code'],
            self::KEY_NOTE_MEDIA => ['nodes', 'id'],
            self::KEY_NOTE_OWNER => ['nodes', 'owner', 'id'],
        ]
    ];

    /**
     * Config key final data after extract data response
     *
     * @var array
     */
    public static $dataMapCompare = [
        self::KEY_NOTE_IMG_THUMB,
        self::KEY_NOTE_OWNER,
        self::KEY_NOTE_CODE,
        self::KEY_NOTE_MEDIA
    ];

    /**
     * DataMap constructor.
     * @param array $dataMap
     */

    public function __construct(array $dataMap = [])
    {
        self::$dataMap = empty($dataMap) ? self::$dataMap : array_merge(self::$dataMap, $dataMap);
    }

    /**
     * @return array: data map
     */

    public static function getDataMap()
    {
        return self::$dataMap;
    }

    /**
     * @param $nameElement
     * @return bool
     */

    public function checkElementDataMap($nameElement)
    {
        return isset(self::getDataMap()[$nameElement]) ? self::getDataMap()[$nameElement] : false;
    }

}