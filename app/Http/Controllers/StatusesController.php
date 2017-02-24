<?php

namespace blog\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use blog\models\user;
use blog\models\Status;
use blog\Http\Requests;
use blog\Http\Controllers\Controller;

class StatusesController extends Controller
{
    public function postStatus(Request $request) 
    {
       $this->validate($request, [
           'status' => 'required|max:1000',
       ]);
        
        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);
        
        return redirect()
            ->route('home')
            ->with('info',  'status update');
    }
    
    public function postReply(Request $request, $statusId)
    {
           $this->validate($request, [
               "reply-{$statusId}" => 'required|max:1000',
               ], [
                    'required' => 'The reply body is required',
           ]);
        $status = Status::notReply()->find($statusId);
        
        if(!$status) {
            return redirect()->route('home');
        }
        if(!Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user->id) {
            return redirect()->route('home');
        }
        if(!Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user->id) {
            return redirect()->route('home');
        }
        
        $reply = new Status;
        $reply->user_id = Auth::user()->id;
        $reply->parent_id = $status->id;
        $reply->body = $request["reply-{$statusId}"];
        
        $reply->save();
        
        return redirect()->back();
    }
    
    public function getLike($statusId)
    {
        $status = Status::find($statusId);
        
        if(!$status){
            redirect()->route('home');
        }
        
        if(!Auth::user()->isFriendWith($status->user)){
            redirect()->route('home');
        }
        
        if(Auth::user()->hasLikedStatus($status)){
            return redirect()->back();
        }
        
        $like = $status->likes()->create([]);
        Auth::user()->likes()->save($like);
        
        return redirect()->back();
        
    }
    
}
















