<?php declare(strict_types=1);
namespace App\Movie\Services;

use App\Services\CacheServiceFactory;

/**
 *
 * @author charles
 *
 */
class MovieServiceCacheProxy implements MovieServiceInterface
{
    const MOVIE_GENRES_CACHE_PREFIX = "MOVIE_GENRES";

    /**
     *
     * @var MovieServiceInterface
     */
    private $movieServiceInterface;
    
    /**
     * @var CacheServiceFactory
     */
    private $cacheServiceFactory;
    
    public function __construct(MovieServiceInterface $movieServiceInterface, CacheServiceFactory $cacheServiceFactory)
    {
        $this->movieServiceInterface = $movieServiceInterface;
        $this->cacheServiceFactory = $cacheServiceFactory;
        $this->cacheInterface = $this->cacheServiceFactory->getCacheService();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Movie\Services\MovieServiceInterface::getMovieGenres()
     */
    public function getMovieGenres() : array
    {
        $data = $this->cacheInterface->get(self::MOVIE_GENRES_CACHE_PREFIX);
        if (null == $data) {
            $data = $this->movieServiceInterface->getMovieGenres();
            $this->cacheInterface->put(self::MOVIE_GENRES_CACHE_PREFIX, $data);
        }
        return $data;
    }
}
