<?php
declare(strict_types=1);

namespace App\Age\Models;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    /**
     * @var string
     */
    public $title;
    
    /**
     * @var int
     */
    public $age;
    
    protected $fillable = ['title', 'age'];
}
