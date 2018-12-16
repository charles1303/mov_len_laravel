<?php
namespace Age\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \stdClass;

/**
 *
 * @author charles
 *        
 */
class AgeRepository implements AgeInterface
{
    
    protected $ageModel;

    /**
     */
    public function __construct(Model $ageModel)
    {
        
        $this->ageModel = $ageModel;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Age\Repositories\AgeInterface::loadAges()
     */
    public function loadAges()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('hello in repository');
    }
    
    /**
     * Gets Age record by id
     * 
     * @param mixed $ageId
     * @return array
     */
    public function getAgeById($ageId)
    {
        $age = DB::select('select * from ages where id = ?', [$ageId]);
        return $age;
    }
    
    /**
     * Converts Eloquent object to standard class
     * 
     * @param mixed $age
     * @return NULL|\stdClass
     */
    protected function convertFormat($age)
    {
        if ($age == null)
        {
            return null;
        }
        
        $object = new stdClass();
        $object->id = $age->id;
        $object->title = $age->title;
        
        return $object;
    }
}

