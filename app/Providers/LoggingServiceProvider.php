<?php
namespace Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

/**
 *
 * @author charles
 *        
 */
class LoggingServiceProvider extends ServiceProvider
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
        // TODO - Insert your code here
    }
    
    public function register()
    {
        Log::useFiles(env('APP_LOG_FILE'), config('app.log_level', 'debug'));
        $handlers = Log::getMonolog()->getHandlers();
        $handler = array_shift($handlers);
        $handler->setBubble(false);
        
    }
}

