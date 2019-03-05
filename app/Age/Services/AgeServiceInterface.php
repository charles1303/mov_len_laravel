<?php
namespace app\Age\Services;

/**
 *
 * @author charles
 *
 */
interface AgeServiceInterface
{
    /**
     * Gets age by age Id
     *
     * @param int $ageId
     * @return object
     */
    public function getAgeById(int $ageId) : object;
    
    /**
     * Gets all Ages
     *
     * @return array
     */
    public function getAges() : array;
}
