<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use DateInterval;
use Laravel\Passport\Bridge\PersonalAccessGrant;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        app(AuthorizationServer::class)->enableGrantType(
            new PersonalAccessGrant, new DateInterval('PT1H')
            );
        
        Passport::routes();
        
        Passport::tokensExpireIn(now()->addMinutes(30));
        
        Passport::tokensCan([
            'ratings' => 'View Ratings',
            'ages' => 'View Ages',
            'movies' => 'View Movies'
        ]);
    }
}
