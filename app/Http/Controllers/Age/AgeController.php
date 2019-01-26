<?php

namespace App\Http\Controllers\Age;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Age\Services\AgeService;

class AgeController extends Controller
{
    /**
     * 
     * @var AgeService
     */
    protected $ageService;
    
    public function __construct(AgeService $ageService)
    {
        $this->ageService = $ageService;
    }
    
    public function getAgeById(Request $request, int $ageId)
    {
        return response()->api($this->ageService->getAgeById($ageId));
    }
}
