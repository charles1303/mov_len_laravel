<?php declare(strict_types=1);
namespace Age\Services;

use Age\Repositories\AgeRepositoryInterface;
use App\Services\CacheServiceFactory;
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
    
    /*
     * @var CacheServiceFactory
     */
    protected $cacheServiceFactory;
    
    public function __construct(AgeRepositoryInterface $ageRepo, CacheServiceFactory $cacheServiceFactory)
    {
        $this->ageRepo = $ageRepo;
        $this->cacheServiceFactory = $cacheServiceFactory;
    }
    
    /**
     * Gets age by age Id
     *
     * @param int $ageId
     * @return object
     */
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
        $cacheService = $this->cacheServiceFactory->getCacheService();
        
        return $cacheService->get($this->ageRepo, 'getAges', 'ages');
    }
}
