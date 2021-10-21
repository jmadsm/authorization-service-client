<?php
require_once ('_config.php');

use JmaDsm\AuthorizationService\Client;

$client = new Client($config['authorization_service_api_url'], $config['authorization_service_api_token'], false);

try {
    $authorization = $client->getScopes($config['tenant_token'], $config['no']);

    print_r($authorization);
} catch (\GuzzleHttp\Exception\ClientException $e) {
    $e->getResponse();
}