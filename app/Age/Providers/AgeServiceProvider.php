<?php
namespace Age\Providers;

use Illuminate\Support\ServiceProvider;
use Age\Services\AgeService;

/**
 *
 * @author charles
 *        
 */
class AgeServiceProvider extends ServiceProvider
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
        // Bind the returned class to the namespace 'Age\Services\AgeService
        $this->app->bind('Age\Services\AgeService', function($app)
        {
            return new AgeService(
                // Inject in our class of ageInterface, this will be our repository
                $app->make('Age\Repositories\AgeInterface')
                );
        });
    }
}

