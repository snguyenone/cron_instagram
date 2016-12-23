<?php
namespace Instagram\Type;

use Instagram\Request\FollowerRequest;

class Followers extends Type
{
    protected $follower;
    protected $followerObject;

    /**
     * Followers constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->type = 'follower';
        parent::__construct(new FollowerRequest($client));
    }
}