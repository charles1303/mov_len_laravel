<?php declare(strict_types=1);
namespace Movie\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Movie\Models\Movie;

/**
 *
 * @author charles
 *
 */
class MovieRepository implements MovieRepositoryInterface
{
    
    /**
     *
     * @var Movie
     */
    protected $movieModel;

    public function __construct(Movie $movieModel)
    {
        $this->movieModel = $movieModel;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Movie\Repositories\MovieRepositoryInterface::getMovieGenres()
     */
    public function getMovieGenres() : array
    {
        Log::channel('daily')->info('Fetching genres from DB.....');
        $movieGenres = DB::select('select distinct genres from movies');
        return $movieGenres;
    }
}
