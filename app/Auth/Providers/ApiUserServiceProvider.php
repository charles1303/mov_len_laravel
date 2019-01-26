<?php declare(strict_types=1);
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
        $this->app->bind('Auth\Services\ApiUserService', function($app)
        {
            return new ApiUserService(
                  $app->make('Auth\Repositories\ApiUserRepositoryInterface')
                );
        });
    }
}

