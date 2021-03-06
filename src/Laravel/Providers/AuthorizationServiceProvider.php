<?php

namespace JmaDsm\AuthorizationService\Laravel\Providers;

use JmaDsm\AuthorizationService\Client as AuthorizationServiceClient;

class AuthorizationServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bind AuthorizationServiceClient to container
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/authorization.php' => config_path('authorization.php')
        ], 'authorization-config');

        $this->app->singleton(AuthorizationServiceClient::class, function() {
            return new AuthorizationServiceClient(config('authorization.endpoint'), config('authorization.token'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [AuthorizationServiceClient::class];
    }
}