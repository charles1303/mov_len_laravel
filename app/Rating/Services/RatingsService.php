<?php
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

    protected $ratingsRepo;
    
    /**
     */
    public function __construct(RatingsRepositoryInterface $ratingsRepo)
    {
        
        $this->ratingsRepo = $ratingsRepo;
    }
    
    public function loadPaginatedChartRecords(){
        
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService loadPaginatedChartRecords method....');
        $ratings = $this->ratingsRepo->loadPaginatedChartRecords(1);
        return $this->sortMovieRatings($ratings);
    }
    
    public function loadMovieRatings()
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService loadMovieRatings method....');
        $ratings = $this->ratingsRepo->loadMovieRatings();
        return $this->sortMovieRatings($ratings);
    }
    
    public function searchByAge($ageId)
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService searchByAge method by age Id ' . $ageId);
        $ratings = $this->ratingsRepo->searchByAge($ageId);
        return $this->sortMovieRatings($ratings);
    }
    
    public function searchByGenre($genre)
    {
        Log::channel('daily')->info('Loading paginated movie ratings from RatingsService searchByGenre method by genre ' . $genre);
        $ratings = $this->ratingsRepo->searchByGenre($genre);
        return $this->sortMovieRatings($ratings);
    }
    
    public function sortMovieRatings($movieRatings)
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

