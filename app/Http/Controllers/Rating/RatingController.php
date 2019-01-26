<?php
namespace App\Http\Controllers\Rating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Rating\Services\RatingsService;

/**
 *
 * @author charles
 *        
 */
class RatingController extends Controller
{

    /**
     * 
     * @var RatingsService
     */
    protected $ratingService;   
    public function __construct(RatingsService $ratingService)
    {
        
        $this->ratingService = $ratingService;
    }
    
    public function getPaginatedChartRecords(Request $request){
        Log::channel('daily')->info('Loading paginated movie ratings from RatingController loadPaginatedChartRecords method....');
        return response()->api($this->ratingService->getPaginatedChartRecords());
    }
    
    public function getMovieRatings()
    {
        Log::channel('daily')->info('Loading movie ratings from RatingController loadMovieRatings method....');
        return response()->api($this->ratingService->getMovieRatings());
    }
    
    public function searchByAge(int $ageId)
    {
        Log::channel('daily')->info('Search movie ratings from RatingController searchByAge method by age....' . $ageId);
        return response()->api($this->ratingService->searchByAge($ageId));
    }
    
    public function searchByGenre(string $genre)
    {
        Log::channel('daily')->info('Search movie ratings from RatingController searchByGenre method by genre....' . $genre);
        return response()->api($this->ratingService->searchByGenre($genre));
    }
}

