<?php declare(strict_types=1);
namespace Movie\Services;

use App\Services\CacheServiceFactory;
use Movie\Repositories\MovieRespositoryInterface;

/**
 *
 * @author charles
 *
 */
class MovieService
{

    /**
     *
     * @var MovieRespositoryInterface
     */
    protected $movieRepo;
    
    /*
     * @var CacheServiceFactory
     */
    protected $cacheServiceFactory;
    
    public function __construct(MovieRespositoryInterface $movieRepo, CacheServiceFactory $cacheServiceFactory)
    {
        $this->movieRepo = $movieRepo;
        $this->cacheServiceFactory = $cacheServiceFactory;
    }
    /**
     * Gets movie genres
     *
     * @return array
     */
    public function getMovieGenres() : array
    {
        $cacheService = $this->cacheServiceFactory->getCacheService();
        
        return $cacheService->get($this->movieRepo, 'getMovieGenres', 'movies');
    }
}
