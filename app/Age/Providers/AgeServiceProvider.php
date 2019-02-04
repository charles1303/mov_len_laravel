<?php declare(strict_types=1);
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
        $this->app->bind('Age\Services\AgeService', function ($app) {
            return new AgeService(
                $app->make('Age\Repositories\AgeRepositoryInterface'),
                $app->make('App\Services\CacheServiceFactory')
                );
        });
    }
}
