<?php declare(strict_types=1);

namespace App\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class ApiUserTokenScope extends Model
{
    protected $fillable = [
        'token_scope_id','api_user_id'
    ];
    public function tokenScope()
    {
        return $this->belongsTo('App\Auth\Models\TokenScope','id', 'token_scope_id');
    }
}
