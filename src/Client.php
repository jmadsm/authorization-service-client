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
            'headers'  => [
                'Authorization' => 'Bearer ' . $apiToken
            ]
        ]);
    }

    /**
     * @param  string          $tenantId
     * @param  string          $contactPersonNo
     * @return array
     * @throws GuzzleException
     */
    public function getScopes(string $tenantId, string $contactPersonNo): array
    {
        try {
            $response = $this->guzzleClient->get("api/v1/contact/{$contactPersonNo}?" . http_build_query(['tenant_id' => $tenantId]));
        } catch (RequestException $e) {
            if (!$e->hasResponse() || $e->getResponse()->getStatusCode() !== '404') {
                throw $e;
            }

            $response = $e->getResponse();
        }

        return json_decode($response->getBody(), true);
    }
}
