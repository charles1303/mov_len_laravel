<?php declare(strict_types=1);
namespace Rating\Repositories;

/**
 *
 * @author charles
 *
 */
interface RatingsRepositoryInterface
{
    public function getPaginatedChartRecords(int $page) : array;
    public function getMovieRatings() : array;
    public function searchByAge(int $age_id) : array;
    public function searchByGenre(string $genre) : array;
}
