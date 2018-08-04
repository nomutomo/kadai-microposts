<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Micropost; //追加

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(2);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        
        if( isset($user) ) {
            
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(2);
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
            $data += $this->counts($user);
            return view('users.show', $data);
        }else {
            return back();
        }
            
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        
        if( isset($user) ) {
            $followings = $user->followings()->paginate(2);
            
            $data = [
                'user' => $user,
                'users' => $followings,
            ];
            
            $data += $this->counts($user);
            
            return view('users.followings', $data);
        }else {
            return back();
        }
    }
    
    public function followers($id)
    {

        $user = User::find($id);
        if( isset($user) ) {
            $followers = $user->followers()->paginate(2);
            
            $data =[
                'user' => $user,
                'users' => $followers,
            ];
            
            $data += $this->counts($user);
            
            return view('users.followers', $data);
        }else {
            return back();
        }
    }
    
    public function favorites($id)
    {
        $user = User::find($id);
        
        if( isset($user) ) {
            
            $microposts = $user->favorites()->orderBy('created_at', 'desc')->paginate(2);
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
            $data += $this->counts($user);
            return view('users.favorites', $data);
        }else {
            return back();
        }
    }
    
}
