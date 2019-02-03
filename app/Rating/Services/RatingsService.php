<?php declare(strict_types=1);
namespace Rating\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Rating\Repositories\RatingsRepositoryInterface;

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
    
    public function __construct(RatingsRepositoryInterface $ratingsRepo)
    {
        $this->ratingsRepo = $ratingsRepo;
    }
    
    public function getPaginatedChartRecords(int $page) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getPaginatedChartRecords method 2 ....');
        
        $ratings = Cache::get('paginated:records:' . $page, function () use ($page) {
            $resultSet = $this->ratingsRepo->getPaginatedChartRecords($page);
            $movieRatings =  $this->sortMovieRatings($resultSet);
            Cache::put('paginated:records:' . $page, $movieRatings, env('MEMCACHED_DURATION_IN_MINUTES'));
            return $movieRatings;
        });
        return $ratings;
    }
    
    public function getMovieRatings() : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getMovieRatings method....');
        
        $ratings = Cache::get('movie:ratings', function () {
            $resultSet = $this->ratingsRepo->getMovieRatings();
            $movieRatings =  $this->sortMovieRatings($resultSet);
            Cache::put('movie:ratings', $movieRatings, env('MEMCACHED_DURATION_IN_MINUTES'));
            return $movieRatings;
        });
        return $ratings;
    }
    
    public function searchByAge(int $ageId) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByAge method by age Id ' . $ageId);
        
        $ratings = Cache::get('movie:ratings:'.$ageId, function () use ($ageId) {
            $resultSet = $this->ratingsRepo->searchByAge($ageId);
            $movieRatings =  $this->sortMovieRatings($resultSet);
            Cache::put('movie:ratings:'.$ageId, $movieRatings, env('MEMCACHED_DURATION_IN_MINUTES'));
            return $movieRatings;
        });
        return $ratings;
    }
    
    public function searchByGenre(string $genre) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByGenre method by genre ' . $genre);
        
        $ratings = Cache::remember('movie:ratings:'.$genre, env('MEMCACHED_DURATION_IN_MINUTES'), function () use ($genre) {
            $resultSet = $this->ratingsRepo->searchByGenre($genre);
            $movieRatings =  $this->sortMovieRatings($resultSet);
            return $movieRatings;
        });
        return $ratings;
    }
    
    public function saveNewRatings() : string
    {
        Log::channel('daily')->info('Mimic Saving new ratings and flushing cache so as to update data retreived.....');
        Cache::flush();
        
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
