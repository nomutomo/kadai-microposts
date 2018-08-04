<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MicropostsController extends Controller
{

    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            if( isset($user) ) {
                $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(5);
    
                $data = [
                    'user' => $user,
                    'microposts' => $microposts,
                ];
            }
        }
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);
        
        if( isset($micropost) ) {
            if (\Auth::id() === $micropost->user_id) {
                $micropost->delete();
            }
        }
        
        return redirect()->back();
    }
    
}
