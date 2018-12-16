<?php
namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

/**
 *
 * @author charles
 *        
 */
class ResponseServiceProvider extends ServiceProvider
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
    
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data) use ($factory) {
            
            $customFormat = [
                'status' => 200,
                'message' => "success",
                'data' => $data
            ];
            return $factory->make($customFormat);
        });
    }
}

