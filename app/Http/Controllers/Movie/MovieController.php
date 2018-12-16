<?php

namespace App\Http\Controllers\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Movie\Services\MovieService;

class MovieController extends Controller
{
    protected $movieService;
    
    public function __construct(MovieService $movieService){
        $this->movieService = $movieService;
        
    }
    
    public function loadMovieGenres(Request $request){
        //$output = new \Symfony\Component\Console\Output\ConsoleOutput();
        //$output->writeln('hello in movie controller...');
        return response()->api($this->movieService->loadMovieGenres());
    }
}
