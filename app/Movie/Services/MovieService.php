<?php
namespace Movie\Services;

use Movie\Repositories\MovieRespositoryInterface;

/**
 *
 * @author charles
 *        
 */
class MovieService
{

    protected $movieRepo;
    
    /**
     */
    public function __construct(MovieRespositoryInterface $movieRepo)
    {
        
       $this->movieRepo = $movieRepo;
    }
    
    public function loadMovieGenres()
    {
        return $this->movieRepo->loadMovieGenres();
    }
}

