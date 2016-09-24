<?php

namespace blog\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;



class Status extends Model {
    
    protected  $table =  'statuses';                    
    protected  $fillable =[
      'body'  
    ];       
    
    public function user()
    {
        return $this->belongsTo('blog\models\user', 'user_id');
    }
    
    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }
    
    public function replies()
    {
        return $this->hasMany('blog\models\Status', 'parent_id');
    }
    
    public function likes()
    {
        return $this->morphMany('blog\models\Like', 'likeable');
    }
    
}