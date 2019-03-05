<?php declare(strict_types=1);
namespace Movie\Repositories;

/**
 *
 * @author charles
 *
 */
interface MovieRepositoryInterface
{
    public function getMovieGenres() : array;
}
