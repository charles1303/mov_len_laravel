<?php
namespace Rating\Providers;

use Illuminate\Support\ServiceProvider;
use Rating\Services\RatingsService;

/**
 *
 * @author charles
 *        
 */
class RatingsServiceProvider extends ServiceProvider
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
        // Bind the returned class to the namespace 'Rating\Services\RatingsService
        $this->app->bind('Rating\Services\RatingsService', function($app)
        {
            return new RatingsService(
                
                $app->make('Rating\Repositories\RatingsRepositoryInterface')
                );
        });
    }
}

