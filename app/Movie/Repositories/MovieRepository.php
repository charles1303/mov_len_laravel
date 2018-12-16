<?php
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
    
    protected $movieModel;

    /**
     */
    public function __construct(Movie $movieModel)
    {
        
       $this->movieModel = $movieModel;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Movie\Repositories\MovieRespositoryInterface::loadMovieGenres()
     */
    public function loadMovieGenres()
    {
        
        $movieGenres = DB::select('select distinct genres from movies');
        return $movieGenres;
    }
}

