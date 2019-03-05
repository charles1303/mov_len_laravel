<?php
declare(strict_types=1);
namespace Age\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exceptions\NoRecordFoundException;

/**
 *
 * @author charles
 *
 */
class AgeRepository implements AgeRepositoryInterface
{
    protected $ageModel;

    /**
     */
    public function __construct(Model $ageModel)
    {
        $this->ageModel = $ageModel;
    }
    
    /**
     * Gets Age record by id
     *
     * @param mixed $ageId
     * @return object
     */
    public function getAgeById(int $ageId) : object
    {
        Log::channel('daily')->info('Fetching getAgeById from DB.....');
        $age = DB::select('select * from ages where id = ?', [$ageId]);
        if (count($age) < 1) {
            throw new NoRecordFoundException("No records found");
        }
        return $age[0];
    }
    
    /**
     * Gets all Ages
     *
     * @return array
     */
    public function getAges() : array
    {
        Log::channel('daily')->info('Fetching getAges from DB.....');
        $ages = DB::select('select * from ages');
        if (count($ages) < 1) {
            throw new NoRecordFoundException("No records found");
        }
        return $ages;
    }
}
