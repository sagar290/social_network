<?php

namespace blog\Http\Controllers;

use Illuminate\Http\Request;
use blog\models\Status;
use blog\Http\Requests;
use blog\Http\Controllers\Controller;
use Auth;


class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            
            
            $statuses = Status::notReply()->where(function($query) {
                return $query->where('user_id', Auth::user()->id)
                    ->orWhereIn('user_id', Auth::user()->friends()->lists('id'));
            })->orderBy('created_at', 'desc')->paginate(5);
            
           
            
            return view('timeline.index')->with('statuses', $statuses);
        }
        
        return view('home');
    }
}
