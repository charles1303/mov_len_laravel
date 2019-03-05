<?php declare(strict_types=1);

namespace App\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class TokenScope extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
