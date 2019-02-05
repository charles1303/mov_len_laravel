<?php declare(strict_types=1);
namespace Rating\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Rating\Repositories\RatingsRepositoryInterface;
use App\Services\CacheServiceFactory;

/**
 *
 * @author charles
 *
 */
class RatingsService
{

    /**
     *
     * @var RatingsRepositoryInterface
     */
    protected $ratingsRepo;
    
    /*
     * @var CacheServiceFactory
     */
    protected $cacheServiceFactory;
    
    public function __construct(RatingsRepositoryInterface $ratingsRepo, CacheServiceFactory $cacheServiceFactory)
    {
        $this->ratingsRepo = $ratingsRepo;
        $this->cacheServiceFactory = $cacheServiceFactory;
    }
    
    public function getPaginatedChartRecords(int $page) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getPaginatedChartRecords method 2 ....');
        
        $cacheService = $this->cacheServiceFactory->getCacheService();
        $data =  $cacheService->get($this->ratingsRepo, 'getPaginatedChartRecords', 'paginated:records', $page);
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    public function getMovieRatings() : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getMovieRatings method....');
        
        $cacheService = $this->cacheServiceFactory->getCacheService();
        $data =  $cacheService->get($this->ratingsRepo, 'getMovieRatings', 'movie:ratings');
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    public function searchByAge(int $ageId) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByAge method by age Id ' . $ageId);
        
        $cacheService = $this->cacheServiceFactory->getCacheService();
        $data =  $cacheService->get($this->ratingsRepo, 'searchByAge', 'movie:ratings', $ageId);
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    public function searchByGenre(string $genre) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByGenre method by genre ' . $genre);
        
        $cacheService = $this->cacheServiceFactory->getCacheService();
        $data =  $cacheService->get($this->ratingsRepo, 'searchByGenre', 'movie:ratings', $genre);
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    public function clearCache() : string
    {
        Log::channel('daily')->info('Mimic Saving new ratings and flushing cache so as to update data retreived.....');
        $cacheService = $this->cacheServiceFactory->getCacheService();
        $cacheService->clearCache();
        return 'Cache flushed and data refreshed';
    }
    
    public function sortMovieRatings(array $movieRatings) : array
    {
        Log::channel('daily')->info('Sorting movie ratings from RatingsService sortMovieRatings method....size ' .count($movieRatings));
        if (isset($movieRatings) && is_array($movieRatings) && count($movieRatings) > 0) {
            usort($movieRatings, function ($a, $b) {
                if ($a->avg_rating === $b->avg_rating) {
                    return ($b->noOfRatings <=> $a->noOfRatings);
                } else {
                    return ($b->avg_rating <=> $a->avg_rating);
                }
            });
        } else {
            $movieRatings = [];
        }
        
        return $movieRatings;
    }
}
