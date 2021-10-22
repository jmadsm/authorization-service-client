# JMA Authorization Service Client

## Install package
```console
composer require jmadsm/authorization-service-client
```

## Laravel
```console
php artisan vendor:publish --tag=authorization-config --ansi
```

### Get Scope with Laravel
```php
use Illuminate\Support\Facades\App;
use JmaDsm\AuthorizationService\Client as AuthorizationServiceClient;

$authorization = (App::make(AuthorizationServiceClient::class))->getScopes($tenant_token, $no);
```

## Example
See examples directory
