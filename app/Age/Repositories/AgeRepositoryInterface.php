<?php
declare(strict_types=1);
namespace Age\Repositories;

/**
 *
 * @author charles
 *
 */
interface AgeRepositoryInterface
{
    /**
     * Gets Age record by id
     *
     * @param mixed $ageId
     * @return array
     */
    public function getAgeById(int $ageId) : object;
    
    /**
     * Gets all Ages
     *
     * @return array
     */
    public function getAges() : array;
}
