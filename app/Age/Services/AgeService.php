<?php declare(strict_types=1);
namespace Age\Services;

use Age\Repositories\AgeRepositoryInterface;
use Illuminate\Support\Facades\Cache;

/**
 *
 * @author charles
 *
 */
class AgeService
{
    /*
     * @var AgeRepositoryInterface
     */
    protected $ageRepo;
    
    public function __construct(AgeRepositoryInterface $ageRepo)
    {
        $this->ageRepo = $ageRepo;
    }
    
    public function getAgeById(int $ageId) : object
    {
        return $this->ageRepo->getAgeById($ageId);
    }
    
    /**
     * Gets all Ages
     *
     * @return array
     */
    public function getAges() : array
    {
        $ages = Cache::remember('ages', env('MEMCACHED_DURATION_IN_MINUTES'), function () {
            $resultSet = $this->ageRepo->getAges();
            return $resultSet;
        });
        return $ages;
    }
   
}
