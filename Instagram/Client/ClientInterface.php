<?php
namespace Instagram\Client;

interface ClientInterface
{
    public function __construct(\GuzzleHttp\ClientInterface $client, array $options = []);

    public function setClient($client, array $options);

    public function getClient();

}