<?php declare(strict_types=1);
namespace Rating\Services;

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
    
    public function getPaginatedChartRecords() : array{
        
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService loadPaginatedChartRecords method....');
        $ratings = $this->ratingsRepo->getPaginatedChartRecords(1);
        return $this->sortMovieRatings($ratings);
    }
    
    public function getMovieRatings() : array
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService loadMovieRatings method....');
        $ratings = $this->ratingsRepo->getMovieRatings();
        return $this->sortMovieRatings($ratings);
    }
    
    public function searchByAge(int $ageId) : array
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService searchByAge method by age Id ' . $ageId);
        $ratings = $this->ratingsRepo->searchByAge($ageId);
        return $this->sortMovieRatings($ratings);
    }
    
    public function searchByGenre(string $genre) : array
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService searchByGenre method by genre ' . $genre);
        $ratings = $this->ratingsRepo->searchByGenre($genre);
        return $this->sortMovieRatings($ratings);
    }
    
    public function sortMovieRatings(array $movieRatings) : array
    {
        Log::channel('daily')->info('Sorting movie ratings from RatingsService sortMovieRatings method....size ' .count($movieRatings));
        if(isset($movieRatings) && is_array($movieRatings) && count($movieRatings) > 0){
            usort($movieRatings, function($a,$b) {
                if($a->avg_rating === $b->avg_rating)
                {
                    return ($b->noOfRatings <=> $a->noOfRatings);
                }else{
                    return ($b->avg_rating <=> $a->avg_rating);
                }
                
            });
        }else{
            $movieRatings = [];
        }
        
        return $movieRatings;
    }
}

