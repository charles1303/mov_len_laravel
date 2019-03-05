<?php declare(strict_types=1);
namespace App\Rating\Services;

use App\Services\CacheServiceFactory;
use App\Services\CacheServiceInterface;

/**
 *
 * @author charles
 *
 */
class RatingsServiceCacheProxy implements RatingsServiceInterface
{
    const CACHE_PREFIX = "AGE_RATINGS";
    const MOVIE_CACHE_PREFIX = "MOVIE_RATINGS";
    const MOVIE_BY_GENRE_CACHE_PREFIX = "MOVIE_BY_GENRE";
    const PAGINATED_CACHE_PREFIX = "PAGINATED_RATINGS";
    
    
    /**
     *
     * @var RatingsServiceInterface
     */
    private $ratingsServiceInterface;
    
    /**
     * @var CacheServiceFactory
     */
    private $cacheServiceFactory;
    
    /**
     *
     * @var CacheServiceInterface
     */
    private $cacheInterface;
   
    public function __construct(RatingsServiceInterface $ratingsServiceInterface, CacheServiceFactory $cacheServiceFactory)
    {
        $this->ratingsServiceInterface = $ratingsServiceInterface;
        $this->cacheServiceFactory = $cacheServiceFactory;
        $this->cacheInterface = $this->cacheServiceFactory->getCacheService();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Rating\Services\RatingsServiceInterface::searchByAge()
     */
    public function searchByAge(int $ageId) : array
    {
        $data = $this->cacheInterface->get(self::CACHE_PREFIX .':'. $ageId);
        if (null == $data) {
            $data = $this->ratingsServiceInterface->searchByAge($ageId);
            $this->cacheInterface->put(self::CACHE_PREFIX .':'. $ageId, $data);
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Rating\Services\RatingsServiceInterface::getMovieRatings()
     */
    public function getMovieRatings() : array
    {
        $data = $this->cacheInterface->get(self::MOVIE_CACHE_PREFIX);
        if (null == $data) {
            $data = $this->ratingsServiceInterface->getMovieRatings();
            $this->cacheInterface->put(self::MOVIE_CACHE_PREFIX, $data);
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Rating\Services\RatingsServiceInterface::searchByGenre()
     */
    public function searchByGenre(string $genre) : array
    {
        $data = $this->cacheInterface->get(self::MOVIE_BY_GENRE_CACHE_PREFIX.':'. $genre);
        if (null == $data) {
            $data = $this->ratingsServiceInterface->searchByGenre($genre);
            $this->cacheInterface->put(self::MOVIE_BY_GENRE_CACHE_PREFIX.':'. $genre, $data);
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Rating\Services\RatingsServiceInterface::save()
     */
    public function save() : string
    {
        $this->cacheInterface->clearCache();
        return 'Cache flushed and data refreshed';
    }

    /**
     * (non-PHPdoc)
     *
     * @see \App\Rating\Services\RatingsServiceInterface::getPaginatedChartRecords()
     */
    public function getPaginatedChartRecords(int $page = 1) : array
    {
        $data = $this->cacheInterface->get(self::PAGINATED_CACHE_PREFIX.':'. $page);
        if (null == $data) {
            $data = $this->ratingsServiceInterface->getPaginatedChartRecords($page);
            $this->cacheInterface->put(self::PAGINATED_CACHE_PREFIX.':'. $page, $data);
        }
        return $data;
    }
}
