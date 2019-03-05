<?php declare(strict_types=1);
namespace Age\Services;

use Age\Repositories\AgeRepositoryInterface;
use app\Age\Services\AgeServiceInterface;

/**
 *
 * @author charles
 *
 */
class AgeService implements AgeServiceInterface
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
    
    
    public function getAges() : array
    {
        return $this->ageRepo->getAge();
    }
}
