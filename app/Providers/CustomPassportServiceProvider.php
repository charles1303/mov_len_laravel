<?php
namespace App\Providers;

use Laravel\Passport\PassportServiceProvider;
use DateInterval;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;

/**
 *
 * @author charles
 *        
 */
class CustomPassportServiceProvider extends PassportServiceProvider
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }
    
    /**
     * Register the authorization server.
     *
     * @return void
     */
    protected function registerAuthorizationServer()
    {
        $this->app->singleton(AuthorizationServer::class, function () {
            return tap($this->makeAuthorizationServer(), function ($server) {
                $server->enableGrantType(
                    $this->makeAuthCodeGrant(), Passport::tokensExpireIn()
                    );
                
                $server->enableGrantType(
                    $this->makeRefreshTokenGrant(), Passport::tokensExpireIn()
                    );
                
                $server->enableGrantType(
                    $this->makePasswordGrant(), Passport::tokensExpireIn()
                    );
                
                $server->enableGrantType(
                    new PersonalAccessGrant, new DateInterval('PT1H')
                    );
                
                $server->enableGrantType(
                    new ClientCredentialsGrant, Passport::tokensExpireIn()
                    );
                
                if (Passport::$implicitGrantEnabled) {
                    $server->enableGrantType(
                        $this->makeImplicitGrant(), Passport::tokensExpireIn()
                        );
                }
            });
        });
    }
}

