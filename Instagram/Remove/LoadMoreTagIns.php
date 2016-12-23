<?php
namespace Instagram;

use GuzzleHttp\ClientInterface;

class LoadMoreTagIns extends BaseIns
{
    protected $response;
    protected $resLoadMore;

    public function __construct($contentResponse, $scriptEx = '')
    {
        parent::__construct($contentResponse, $scriptEx);
        $this->getLastCursorTag();
    }

    public function getLastCursorTag()
    {
        $lastCursor = null;
        try {
            $lastCursor = $this->getScriptDataIns()->entry_data->TagPage[0]->tag->media->page_info->end_cursor;
        } catch (\Exception $e) {
            new \Exception($e->getMessage());
        }

        return $lastCursor;
    }

    public function sendPostLoadMoreTag(ClientInterface $client, $pathUri = '/query')
    {
        $this->response = $client->post(BASE_URL . $pathUri, [
            'form_params' => [
                'q' => 'ig_hashtag(love) { media.after('.$this->getLastCursorTag().', 1) {
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
            ]
        ]);
    }
}