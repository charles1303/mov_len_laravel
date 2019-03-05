<?php declare(strict_types=1);

namespace App\Http\Controllers\Movie;

use App\Http\Controllers\Controller;
use App\Movie\Services\MovieServiceInterface;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    
    /**
     *
     * @var MovieServiceInterface
     */
    protected $movieService;
    
    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }
    
    public function getMovieGenres(Request $request)
    {
        return response()->api($this->movieService->getMovieGenres());
    }
}
