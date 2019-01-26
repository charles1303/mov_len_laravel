<?php declare(strict_types=1);
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
        $this->app->bind('Rating\Repositories\RatingsRepositoryInterface', function($app)
        {
            return new RatingsRepository();
        });
    }
}

