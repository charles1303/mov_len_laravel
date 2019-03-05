<?php declare(strict_types=1);
namespace Rating\Services;

use Illuminate\Support\Facades\Log;
use Rating\Repositories\RatingsRepositoryInterface;
use App\Rating\Services\RatingsServiceInterface;

/**
 *
 * @author charles
 *
 */
class RatingsService implements RatingsServiceInterface
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
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Rating\Services\RatingsServiceInterface::getPaginatedChartRecords()
     */
    public function getPaginatedChartRecords(int $page = 1) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getPaginatedChartRecords method 2 ....');
        
        $data =  $this->ratingsRepo->getPaginatedChartRecords();
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Rating\Services\RatingsServiceInterface::getMovieRatings()
     */
    public function getMovieRatings() : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService getMovieRatings method....');
        
        $data =  $this->ratingsRepo->getMovieRatings();
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Rating\Services\RatingsServiceInterface::searchByAge()
     */
    public function searchByAge(int $ageId) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByAge method by age Id ' . $ageId);
        
        $data = $this->ratingsRepo->searchByAge($ageId);
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Rating\Services\RatingsServiceInterface::searchByGenre()
     */
    public function searchByGenre(string $genre) : array
    {
        Log::channel('daily')->info('Fetching paginated movie ratings from RatingsService searchByGenre method by genre ' . $genre);
        
        $data =  $this->ratingsRepo->searchByGenre($genre);
        $sortedData =  $this->sortMovieRatings($data);
        return $sortedData;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Rating\Services\RatingsServiceInterface::save()
     */
    public function save() : string
    {
        return 'Cache flushed and data refreshed';
    }
    
    /**
     * Sorts movie ratings by no of ratings per movie
     *
     * @param array $movieRatings
     * @return array
     */
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
