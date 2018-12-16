<?php
namespace Rating\Providers;

use Illuminate\Support\ServiceProvider;
use Rating\Repositories\RatingsRepository;

/**
 *
 * @author charles
 *        
 */
class RatingsRepositoryServiceProvider extends ServiceProvider
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
        // Bind the returned class to the namespace 'Rating\Repositories\RatingsRepositoryInterface
        $this->app->bind('Rating\Repositories\RatingsRepositoryInterface', function($app)
        {
            return new RatingsRepository();
        });
    }
}

