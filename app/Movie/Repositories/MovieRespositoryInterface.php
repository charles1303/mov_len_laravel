<?php declare(strict_types=1);
namespace Movie\Repositories;

/**
 *
 * @author charles
 *        
 */
interface MovieRespositoryInterface
{
    public function getMovieGenres() : array;
}

