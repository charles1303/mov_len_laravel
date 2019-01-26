<?php

namespace App\Http\Controllers\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Movie\Services\MovieService;

class MovieController extends Controller
{
    
    /**
     * 
     * @var MovieService
     */
    protected $movieService;
    
    public function __construct(MovieService $movieService){
        $this->movieService = $movieService;
        
    }
    
    public function getMovieGenres(Request $request){
        return response()->api($this->movieService->getMovieGenres());
    }
}
