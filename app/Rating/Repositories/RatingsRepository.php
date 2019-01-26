<?php declare(strict_types=1);
namespace Rating\Repositories;

use Exceptions\QueryException;
use Illuminate\Support\Facades\DB;
use Exceptions\GeneralException;
use Exceptions\NoRecordFoundException;

/**
 *
 * @author charles
 *        
 */
class RatingsRepository implements RatingsRepositoryInterface
{

    private const NUM_OF_RECS_PER_PAGE = 20;

    /**
     * (non-PHPdoc)
     *
     * @see \Rating\Repositories\RatingsRepositoryInterface::loadMovieRatings()
     */
    public function getMovieRatings() : array
    {
        try {
            $sql = <<<'EOT'
            select ROUND((totalRatings/noOfRatings),2) as avg_rating, m.title, noOfRatings from
            (select sum(rating) as totalRatings, count(movie_id) as noOfRatings, movie_id from ratings r
            GROUP BY movie_id
            HAVING noOfRatings > 20
            LIMIT 100) as T
            join movies m on T.movie_id = m.id
            ORDER BY avg_rating desc
EOT;
            
            $result = DB::select($sql);
            if(count($result) < 1){
                throw new NoRecordFoundException("No records found");
            }
            $data = $this->prepareRatingsData($result);
        } catch (\Exception $e) {
            if($e instanceof NoRecordFoundException){
                throw $e;
            }else{
                throw new QueryException("Error Executing Query");
            }
        }
        
        return $data;
    }

   /**
     * (non-PHPdoc)
     *
     * @see \Rating\Repositories\RatingsRepositoryInterface::searchByAge()
     */
    public function searchByAge(int $ageId) : array
    {
        $data = [];
        $sql = <<<EOT
            select ROUND((totalRatings/noOfRatings),2) as avg_rating, m.title, noOfRatings from(
            select sum(rating) as totalRatings, count(movie_id) as noOfRatings, movie_id from
            (select id as user_id,u.age_id,ageValue from(
                select id as age_id, title as ageValue from ages
                where id = ?
                )as ages
                JOIN users u on ages.age_id = u.age_id
                ) as U join ratings r ON
            U.user_id = r.user_id
            GROUP BY movie_id
            HAVING noOfRatings > 20
            LIMIT 100) as T
            join movies m on T.movie_id = m.id
            ORDER BY avg_rating desc
EOT;
        try {
            $result = DB::select($sql, [
                $ageId
            ]);
            
            if(count($result) < 1){
                throw new NoRecordFoundException("No records found");
            }
            $data = $this->prepareRatingsData($result);
        } catch (\Exception $e) {
            if($e instanceof NoRecordFoundException){
                throw $e;
            }else{
                throw new QueryException("Error Executing Query");
            }
            
        }
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Rating\Repositories\RatingsRepositoryInterface::searchByGenre()
     */
    public function searchByGenre(string $genre) : array
    {
        
        $data = [];
        $sql = <<<EOT
            select ROUND((totalRatings/noOfRatings),2) as avg_rating, title, noOfRatings from(
            select sum(rating) as totalRatings, count(M.movie_id) as noOfRatings, M.movie_id, M.title as title from
            (
                select id as movie_id,title,genres from movies
                
                ) as M join ratings r ON
            M.movie_id = r.movie_id
            where M.genres = ?
            GROUP BY movie_id
            HAVING noOfRatings > 20
            LIMIT 100) as T
            
            ORDER BY avg_rating desc
EOT;
        
        try {
            $result = DB::select($sql, [
                $genre
            ]);
            if(count($result) < 1){
                throw new NoRecordFoundException("No records found");
            }
            $data = $this->prepareRatingsData($result);
        } catch (\Exception $e) {
            if($e instanceof NoRecordFoundException){
                throw $e;
            }else{
                throw new QueryException("Error Executing Query");
            }
        }
        
        return $data;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Rating\Repositories\RatingsRepositoryInterface::loadPaginatedChartRecords()
     */
    public function getPaginatedChartRecords(int $page) : array
    {
        $data = [];
        $recordIndex = $page * self::NUM_OF_RECS_PER_PAGE;
        try {
            $sql = <<<EOT
            select ROUND((totalRatings/noOfRatings),2) as avg_rating, m.title, noOfRatings from
            (select sum(rating) as totalRatings, count(movie_id) as noOfRatings, movie_id from ratings r
            GROUP BY movie_id
            HAVING noOfRatings > 20
            LIMIT $recordIndex, 10) as T
            join movies m on T.movie_id = m.id
            ORDER BY avg_rating desc
EOT;
            $result = DB::select($sql);
            if(count($result) < 1){
                throw new NoRecordFoundException("No records found");
            }
            $data = $this->prepareRatingsData($result);
        } catch (\Exception $e) {
            if($e instanceof NoRecordFoundException){
                throw $e;
            }else{
                throw new QueryException("Error Executing Query");
            }
        }
        return $data;
    }

    private function prepareRatingsData(array $result) : array
    {
        $data = [];
        try {
            if (isset($result)) {
                foreach ($result as $row) {
                    $row->title = mb_convert_encoding($row->title, 'UTF8', 'UTF8');
                    $row->noOfRatings = ceil($row->noOfRatings / 100) * 100;
                    $data[] = $row;
                }
            }
        } catch (\Exception $e) {
            throw new GeneralException("A generic exception occurred!");
        }
        
        return $data;
    }
}

