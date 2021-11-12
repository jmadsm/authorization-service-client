<?php

namespace JmaDsm\AuthorizationService;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

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
            'headers'  => [
                'Authorization' => 'Bearer ' . $apiToken
            ]
        ]);
    }

    /**
     * @param  string $tenantId
     * @param  string $contactPersonNo
     * @return array
     */
    public function getScopes(string $tenantId, string $contactPersonNo): array
    {
        try {
            $scopes = json_decode($this->guzzleClient->get("api/v1/contact/{$contactPersonNo}?" . http_build_query(['tenant_id' => $tenantId]))->getBody(), true);
        } catch (ClientException $e) {
            if (!$e->hasResponse() || $e->getResponse()->getStatusCode() !== 404) {
                throw $e;
            }

            $scopes = [];
        }

        return $scopes;
    }
}
