<?php

namespace blog\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use blog\models\user;
use blog\Http\Requests;
use blog\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query = $request->input('query');
        
        if(!$query) {
            return redirect()->route('home');
        }
        
        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")
            ->orWhere(DB::raw("username"), 'LIKE', "%{$query}%")->get();
            
        
        return view('search.results')->with('users', $users);
    }
}
