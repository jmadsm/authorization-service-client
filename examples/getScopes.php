<?php

require_once '_config.php';

use JmaDsm\AuthorizationService\Client;

$client = new Client($config['authorization_service_api_url'], $config['authorization_service_api_token'], false);

print_r(
    $client->getScopes($config['tenant_id'], $config['contact_person_no'])
);
