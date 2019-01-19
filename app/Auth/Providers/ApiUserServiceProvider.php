<?php
namespace Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Auth\Services\ApiUserService;

/**
 *
 * @author charles
 *        
 */
class ApiUserServiceProvider extends ServiceProvider
{

    // TODO - Insert your code here
    
    /**
     *
     * @param \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
        
    }
    
    public function register()
    {
        // Bind the returned class to the namespace 'Auth\Services\ApiUserService
        $this->app->bind('Auth\Services\ApiUserService', function($app)
        {
            return new ApiUserService(
                  $app->make('Auth\Repositories\ApiUserRepositoryInterface')
                );
        });
    }
}

