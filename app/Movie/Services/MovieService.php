<?php declare(strict_types=1);
namespace Movie\Services;

use Illuminate\Support\Facades\Cache;
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
    
    public function __construct(MovieRespositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }
    
    public function getMovieGenres() : array
    {
        $movies = Cache::remember('movies', env('MEMCACHED_DURATION_IN_MINUTES'), function () {
            $resultSet = $this->movieRepo->getMovieGenres();
            return $resultSet;
        });
        return $movies;
    }
}
