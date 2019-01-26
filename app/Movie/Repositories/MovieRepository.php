<?php declare(strict_types=1);
namespace Movie\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Movie\Models\Movie;

/**
 *
 * @author charles
 *        
 */
class MovieRepository implements MovieRespositoryInterface
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
     * @see \Movie\Repositories\MovieRespositoryInterface::getMovieGenres()
     */
    public function getMovieGenres() : array
    {
        
        $movieGenres = DB::select('select distinct genres from movies');
        return $movieGenres;
    }
}

