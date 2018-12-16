<?php
namespace Movie\Providers;

use Illuminate\Support\ServiceProvider;
use Movie\Services\MovieService;

/**
 *
 * @author charles
 *        
 */
class MovieServiceProvider extends ServiceProvider
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
        
        $this->app->bind('Movie\Services\MovieService', function($app)
        {
            return new MovieService(
                // Inject in our class of ageInterface, this will be our repository
                $app->make('Movie\Repositories\MovieRepository')
                );
        });
    }
}

