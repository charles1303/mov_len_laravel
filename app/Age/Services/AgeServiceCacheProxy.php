<?php declare(strict_types=1);
namespace App\Age\Services;

use App\Services\CacheServiceFactory;
use App\Services\CacheServiceInterface;
use app\Age\Services\AgeServiceInterface;

/**
 *
 * @author charles
 *
 */
class AgeServiceCacheProxy implements AgeServiceInterface
{
    const CACHE_PREFIX = "AGES";

    /**
     *
     * @var AgeServiceInterface
     */
    private $ageServiceInterface;
    
    /**
     * @var CacheServiceFactory
     */
    private $cacheServiceFactory;
    
    /**
     *
     * @var CacheServiceInterface
     */
    private $cacheInterface;
    
    public function __construct(AgeServiceInterface $ageServiceInterface, CacheServiceFactory $cacheServiceFactory)
    {
        $this->ageServiceInterface = $ageServiceInterface;
        $this->cacheServiceFactory = $cacheServiceFactory;
        $this->cacheInterface = $this->cacheServiceFactory->getCacheService();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\Age\Services\AgeServiceInterface::getAgeById()
     */
    public function getAgeById($ageId)
    {
        $data = $this->cacheInterface->get(self::CACHE_PREFIX .':'. $ageId);
        if (null == $data) {
            $data = $this->ageServiceInterface->getAgeById($ageId);
            $this->cacheInterface->put(self::CACHE_PREFIX .':'. $ageId, $data);
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \app\Age\Services\AgeServiceInterface::getAges()
     */
    public function getAges()
    {
        $data = $this->cacheInterface->get(self::CACHE_PREFIX .':'. $ageId);
        if (null == $data) {
            $data = $this->ageServiceInterface->getAges();
            $this->cacheInterface->put(self::CACHE_PREFIX .':'. $ageId, $data);
        }
        return $data;
    }
}
