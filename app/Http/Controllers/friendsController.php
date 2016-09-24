<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use blog\models\user;
use blog\Http\Requests;
use blog\Http\Controllers\Controller;

class friendsController extends Controller
{
    
    public function getIndex() 
    {
        $friends = Auth::user()->friends();
        $request = Auth::user()->friendsRequests();
        return view('friends.index')
            ->with('friends', $friends)
            ->with('request', $request);
    }
    
    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();
        
        if(!$user) {
            return redirect()
                ->route('home')
                ->with('info', 'That user could not be found');
        }
        
        if(Auth::user()->id === $user->id ) {
            return redirect()->route('home');
        }
        
        if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request allready pending');
        }
        
        if(Auth::user()->isFriendWith($user)) {
            return redirect()
                ->route('profile.index', ['username' => $user->username])->with('info', 'You are allready friends');
        }
        
        Auth::user()->AddFriend($user);
        
        return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'Friend request sent.');
        
    }
    
    
    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();
        
        if(!$user) {
            return redirect()
                ->route('home')
                ->with('info', 'That user could not be found');
        }
        
        if(!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->route('home');
        }
        
        Auth::user()->acceptedFriendRequest($user);
        
        return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'Friend request accepted.');
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

