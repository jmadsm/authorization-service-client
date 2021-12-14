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
            $scopes = json_decode($this->guzzleClient->get("api/contact/{$contactPersonNo}?" . http_build_query(['tenant_id' => $tenantId]))->getBody(), true);
        } catch (ClientException $e) {
            if (!$e->hasResponse() || $e->getResponse()->getStatusCode() !== 404) {
                throw $e;
            }

            $scopes = [];
        }

        return $scopes;
    }

    /**
     * Get array of registered contacts based on contact_no's from $contactNos
     *
     * @param  string|int $tenantId
     * @param  array      $contactNos
     * @return array
     */
    public function getRegisteredContacts($tenantId, array $contactNos): array
    {
        $request  = $this->guzzleClient->post('api/contact/registered', ['json' => ['tenant_id' => $tenantId, 'contacts' => $contactNos]]);
        $response = json_decode($request->getBody(), true);

        return $response;
    }
}
