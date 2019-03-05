<?php declare(strict_types=1);
namespace Age\Providers;

use Illuminate\Support\ServiceProvider;
use app\Age\Services\AgeServiceInterface;
use Age\Services\AgeService;
use App\Age\Services\AgeServiceCacheProxy;
use App\Http\Controllers\Age\AgeController;

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
                $app->make('Age\Repositories\AgeRepositoryInterface')
                );
        });
        
        $this->app->when(AgeServiceCacheProxy::class)
            ->needs(AgeServiceInterface::class)
            ->give(AgeService::class);
            
        $this->app->when(AgeController::class)
            ->needs(AgeServiceInterface::class)
            ->give(AgeServiceCacheProxy::class);
    }
}
