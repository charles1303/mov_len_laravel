<?php
namespace App\Rating\Services;

/**
 *
 * @author charles
 *
 */
interface RatingsServiceInterface
{
    
    /**
     * Gets paginated ratings sorted by no of ratings per movie
     *
     * @param int $page
     * @return array
     */
    public function getPaginatedChartRecords(int $page = 1) : array;
    
    /**
     * Gets movie ratings sorted by no of ratings per movie
     *
     * @return array
     */
    public function getMovieRatings() : array;
    
    /**
     * Gets movie ratings by age sorted by no of ratings per movie
     *
     * @param int $ageId
     * @return array
     */
    public function searchByAge(int $ageId) : array;
    
    /**
     * Gets movie ratings by genre sorted by no of ratings per movie
     *
     * @param string $genre
     * @return array
     */
    public function searchByGenre(string $genre) : array;
    
    /**
     * Save a ratings record
     *
     * @return string
     */
    public function save() : string;
}
