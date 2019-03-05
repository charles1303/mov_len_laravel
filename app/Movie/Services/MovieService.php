<?php declare(strict_types=1);
namespace Movie\Services;

use App\Movie\Services\MovieServiceInterface;
use Movie\Repositories\MovieRepositoryInterface;

/**
 *
 * @author charles
 *
 */
class MovieService implements MovieServiceInterface
{

    /**
     *
     * @var MovieRepositoryInterface
     */
    protected $movieRepo;
    
    
    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \App\Movie\Services\MovieServiceInterface::getMovieGenres()
     */
    public function getMovieGenres() : array
    {
        return $this->movieRepo->getMovieGenres();
    }
}
