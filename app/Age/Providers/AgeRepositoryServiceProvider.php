<?php
namespace Age\Providers;

use Illuminate\Support\ServiceProvider;
use App\Age\Models\Age;
use Age\Repositories\AgeRepository;

/**
 *
 * @author charles
 *        
 */
class AgeRepositoryServiceProvider extends ServiceProvider
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
        // Bind the returned class to the namespace 'Age\Repositories\AgeInterface
        $this->app->bind('Age\Repositories\AgeInterface', function($app)
        {
            return new AgeRepository(new Age());
        });
    }
}

