<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index(){
        return view('make.make');
    }

    public function login(){
        return view('login.login');
    }

    public function format(){
        return view('format.format');
    }
}
