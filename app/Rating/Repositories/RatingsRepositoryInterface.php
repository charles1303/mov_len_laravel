<?php declare(strict_types=1);
namespace Rating\Repositories;

use Exceptions\NoRecordFoundException;
use Exceptions\QueryException;

/**
 *
 * @author charles
 *
 */
interface RatingsRepositoryInterface
{
    /**
     * Gets paginated ratings records
     *
     * @param int $page
     * @return array
     *
     * @throws NoRecordFoundException if records are not found
     * @throws QueryException if database operation fails
     */
    public function getPaginatedChartRecords(int $page = 1) : array;
    
    /**
     * Gets first 100 movie ratings
     *
     * @return array
     *
     * @throws NoRecordFoundException if records are not found
     * @throws QueryException if database operation fails
     */
    public function getMovieRatings() : array;
    
    /**
     * Gets top ratings by age
     *
     * @param int $age_id
     * @return array
     *
     * @throws NoRecordFoundException if records are not found
     * @throws QueryException if database operation fails
     */
    public function searchByAge(int $age_id) : array;
    
    /**
     * Gets top ratings by genre
     *
     * @param string $genre
     * @return array
     *
     * @throws NoRecordFoundException if records are not found
     * @throws QueryException if database operation fails
     */
    public function searchByGenre(string $genre) : array;
}
