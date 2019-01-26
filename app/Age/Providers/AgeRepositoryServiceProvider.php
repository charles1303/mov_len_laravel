<?php declare(strict_types=1);
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
        $this->app->bind('Age\Repositories\AgeRepositoryInterface', function($app)
        {
            return new AgeRepository(new Age());
        });
    }
}

