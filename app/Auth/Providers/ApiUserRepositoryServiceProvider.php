<?php
namespace Auth\Providers;

use Illuminate\Support\ServiceProvider;
use App\Auth\Models\ApiUser;
use Auth\Repositories\ApiUserRepository;

/**
 *
 * @author charles
 *        
 */
class ApiUserRepositoryServiceProvider extends ServiceProvider
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
        // Bind the returned class to the namespace Auth\Repositories\ApiUserRepositoryInterface
        $this->app->bind('Auth\Repositories\ApiUserRepositoryInterface', function($app)
        {
            return new ApiUserRepository(new ApiUser());
        });
    }
}
