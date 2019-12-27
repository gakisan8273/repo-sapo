<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    public function index(){
        return view('make.make');
    }

    public function login(){
        return view('login.login');
    }

    public function format(){
        $user = User::find(Auth::user()->id);
        return view('format.format', compact('user'));
    }

    public function calcday(){
        return view('calcday.calcday');
    }

    public function editFormat(Request $request){
        $user = User::find(Auth::user()->id);
        $user->hash_tags = $request['hash_tags'];
        $user->format = $request['format'];
        $user->save();

        return redirect('/make');
    }
}
