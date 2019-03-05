<?php declare(strict_types=1);

namespace App\Http\Controllers\Age;

use App\Age\Services\AgeServiceCacheProxy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgeController extends Controller
{
    /**
     *
     * @var AgeServiceCacheProxy
     */
    protected $ageServiceCacheProxy;
    
    public function __construct(AgeServiceCacheProxy $ageServiceCacheProxy)
    {
        $this->ageServiceCacheProxy = $ageServiceCacheProxy;
    }
    
    public function getAgeById(Request $request, int $ageId)
    {
        return response()->api($this->ageServiceCacheProxy->getAgeById($ageId));
    }
    
    public function getAges(Request $request)
    {
        return response()->api($this->ageServiceCacheProxy->getAges());
    }
    
}
