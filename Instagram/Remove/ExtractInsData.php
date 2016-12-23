<?php
namespace Instagram;

class ExtractInsData extends BaseIns
{
    protected $ownerIds;
    protected $mediaIds;

    public function __construct($contentResponse, $scriptEx = '')
    {
        parent::__construct($contentResponse, $scriptEx);
        $this->extract();
    }

    public function extract()
    {
        try {
            $tag = $this->getScriptDataIns()->entry_data->TagPage[0]->tag;
            $this->ownerIds = array_merge($this->buildDataIds($tag, 'media'), $this->buildDataIds($tag, 'top_posts'));
            $this->mediaIds = array_merge($this->buildDataIds($tag, 'media', 'id'), $this->buildDataIds($tag, 'top_posts', 'id'));
        } catch (\Exception $e) {
            new CurlException($e->getMessage());
        }

        return $this;
    }

    public function buildDataIds($data, $nameElement = 'top_posts', $nameEleGet = '')
    {
        $result = [];
        $data = $data->{$nameElement};

        if (empty($data)) {
            new CurlException('Please confirm data param');
        }

        foreach ($data->nodes as $key => $item) {
            try {
                $res = $item->owner->id;
                if ($nameEleGet && property_exists($item, $nameEleGet)) {
                    $res = $item->{$nameEleGet};
                }
                array_push($result, $res);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $result;
    }

    public function getOwnerIds()
    {
        return $this->ownerIds;
    }

    public function getMediaIds()
    {
        return $this->mediaIds;
    }

}