<?php
namespace Exceptions;

/**
 *
 * @author charles
 *        
 */
class NoRecordFoundException extends MovieLensException
{

    protected $status = '404';
    
    /**
     *
     * @param @string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
        
    }
    
    /**
     * Get the status
     *
     * @return int
     */
    public function getStatus()
    {
        return (int) $this->status;
    }  
}

