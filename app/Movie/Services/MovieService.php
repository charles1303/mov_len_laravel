<?php declare(strict_types=1);
namespace Movie\Services;

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
        return $this->movieRepo->getMovieGenres();
    }
}

