<?php

namespace JmaDsm\AuthorizationService;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    /**
     * @var GuzzleClient
     */
    protected GuzzleClient $guzzleClient;

    /**
     * @param string $endpoint
     * @param string $apiToken
     */
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
     * @param string $tenantToken
     * @param string $contactPersonNo
     * @return array
     * @throws GuzzleException
     */
    public function getScopes(string $tenantToken, string $contactPersonNo): array
    {
        $response = $this->guzzleClient->get("api/v1/contact/{$contactPersonNo}?" . http_build_query(['tenant_token' => $tenantToken]));

        return json_decode($response->getBody(), true);
    }
}