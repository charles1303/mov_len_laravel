<?php
declare(strict_types=1);
namespace Age\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;
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
     * @return array
     */
    public function getAgeById(int $ageId) : object
    {
        $age = DB::select('select * from ages where id = ?', [$ageId]);
        if (count($age) < 1) {
            throw new NoRecordFoundException("No records found");
        }
        return $age[0];
    }
    
    /**
     * Converts Eloquent object to standard class
     *
     * @param mixed $age
     * @return NULL|\stdClass
     */
    protected function convertFormat(int $age) : object
    {
        if ($age == null) {
            return null;
        }
        
        $object = new stdClass();
        $object->id = $age->id;
        $object->title = $age->title;
        
        return $object;
    }
}
