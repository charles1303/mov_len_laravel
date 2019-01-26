<?php declare(strict_types=1);
namespace Age\Services;

use Age\Repositories\AgeRepositoryInterface;

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
}
