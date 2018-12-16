<?php
namespace Age\Services;

use Age\Repositories\AgeInterface;

/**
 *
 * @author charles
 *        
 */
class AgeService
{

    protected $ageRepo;
    
    /**
     */
    public function __construct(AgeInterface $ageRepo)
    {
        $this->ageRepo = $ageRepo;
    }
    
    public function getAgeById($ageId){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('hello in services');
        return $this->ageRepo->getAgeById($ageId);
    }
}

