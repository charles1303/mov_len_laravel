<?php

namespace App\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class ApiUser extends Model
{
    use HasApiTokens;
    
    protected $table = 'api_users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function apiUserTokenScopes()
    {
        return $this->hasMany('App\Auth\Models\ApiUserTokenScope','api_user_id', 'id');
    }
    
    
}
