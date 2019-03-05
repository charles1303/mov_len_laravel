<?php
namespace App\Movie\Services;

/**
 *
 * @author charles
 *
 */
interface MovieServiceInterface
{
    /**
     * Gets all movie genres
     *
     * @return array
     */
    public function getMovieGenres() : array;
}
