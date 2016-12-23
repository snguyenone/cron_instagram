<?php
namespace Instagram\Client;

class CurlClient implements ClientInterface
{
    protected $client;

    /**
     * CurlClient constructor.
     * @param \GuzzleHttp\ClientInterface $client
     * @param array $options
     */
    public function __construct(\GuzzleHttp\ClientInterface $client, array $options = [])
    {
        if (!isset($this->client)) {
            $this->setClient($client, $options);
        }
    }

    /**
     * @param $client
     * @param array $options
     * @return $this
     */
    public function setClient($client, array $options)
    {
        $this->client = $options ? $client($options) : $client;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

}