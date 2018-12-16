<?php
namespace Exceptions;

/**
 *
 * @author charles
 *        
 */
class QueryException extends MovieLensException
{

    protected $status = '500';
    
    protected $message;
    
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

