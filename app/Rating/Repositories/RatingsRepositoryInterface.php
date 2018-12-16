<?php
namespace Rating\Repositories;

/**
 *
 * @author charles
 *        
 */
interface RatingsRepositoryInterface
{
    public function loadPaginatedChartRecords(int $page);
    public function loadMovieRatings();
    public function loadChartedRecordsStoredProcCall();
    public function searchByAge(int $age_id);
    public function searchByGenre(String $genre);
    public function searchByGenreAndAge(array $params);
}

