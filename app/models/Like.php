<?php

namespace blog\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class   Like extends Model
{
    protected $table = 'likeable';
    
    public function likeable()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo('blog\models\user', 'user_id');
    }
    
    
}