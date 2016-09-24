<?php

namespace blog\models;

use blog\models\status;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;



class User extends Model implements AuthenticatableContract
                                    
                                    
{
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'email', 
        'password',
        'first_name',
        'last_name',
        'location',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];
    
    public function getName() 
    {
        if($this->first_name && $this->last_name) 
        {
           return "{$this->first_name} {$this->last_name}"; 
        }
        if($this->first_name) 
        {
           return $this->first_name; 
        }
        return null;
    }
    
    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }
    
    public function getFirstNameOrUsername() 
    {
        return $this->first_name ?: $this->username;
    }
   
    public function getAvatarUrl() 
    {
        return "http://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";
    }
    
    public function statuses()
    {
        return $this->hasMany('blog\models\Status', 'user_id');
    }
    
    public function likes()
    {
        return $this->hasMany('blog\models\Like', 'user_id');
    }
    
    public function friendsOfMine()
    {
        return $this->belongsToMany('blog\models\user', 'friends', 'user_id', 'friend_id');
    }
    
    
    
    public function friendOf()
    {
        return $this->belongsToMany('blog\models\user', 'friends', 'friend_id', 'user_id');
    }
    
    
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }
    
    public function friendsRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }
    
    public function friendRequestPending()
    {
        return $this->friendOf()->wherePivot('accepted',  false)->get();
    }
    
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestPending()->where('id', $user->id)->count();
    }
    
    public function hasFriendRequestReceived(user $user)
    {
        return $this->friendsRequests()->where('id', $user->id)->count();
    }
    
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }
    
    public function acceptedFriendRequest(User $user)
    {
        $this->friendsRequests()->where('id', $user->id)->first()->pivot->
            update([
                'accepted' => true,
                ]);
    }
    
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }
    
    public function hasLikedStatus(STATUS $status)
    {
        return (bool) $status->likes->where('user_id', $this->id)->count();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
