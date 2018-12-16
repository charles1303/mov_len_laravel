<?php

namespace App\Http\Controllers\Age;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Age\Services\AgeService;


class AgeController extends Controller
{
    protected $ageService;
    
    public function __construct(AgeService $ageService)
    {
        $this->ageService = $ageService;
    }
    
    public function getAgeById(Request $request, $ageId){
        return response()->api($this->ageService->getAgeById($ageId));
        
    }
}
