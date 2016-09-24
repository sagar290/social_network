<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use blog\models\user;
use blog\Http\Requests;
use blog\Http\Controllers\Controller;

class profileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();
        
        if(!$user){
            return redirect()
                ->route('home')
                ->with('alert', 'That user could not be found');
        }
        
        $statuses = $user->statuses()->notReply()->get();
        
        return view('profile.index')
            ->with('user', $user)
            ->with('statuses', $statuses)
            ->with('authUserIsFriend', Auth::user()->isFriendWith($user));
    }
    
    public function getEdit() 
    {
        return view('profile.edit');
    }
    public function postEdit(Request $request) 
    {
        $this->validate($request, [
            'first_name' => 'alpha|max:50',
            'last_name' => 'alpha|max:50',
            'location' => 'max:20',
        ]);
        
        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
        ]);
        
        return redirect()->route('profile.edit')->with('info', 'Your forfile has been updated');
    }
}
