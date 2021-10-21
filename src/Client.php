<?php

namespace JmaDsm\AuthorizationService;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    protected GuzzleClient $guzzleClient;

    public function __construct(string $endpoint, string $apiToken)
    {
        $this->guzzleClient = new GuzzleClient([
           'base_uri' => $endpoint,
           'headers' => [
               'Authorization' => 'Bearer '. $apiToken
           ]
        ]);
    }

    /**
     * @param string|null $tenantToken
     * @param string|null $no
     * @return array
     * @throws GuzzleException
     */
    public function getScopes(string $tenantToken = null, string $no = null): array
    {
        $response = $this->guzzleClient->get("contact/${no}?" . http_build_query(['tenant_token' => $tenantToken]));

        return json_decode($response->getBody(), true);
    }
}