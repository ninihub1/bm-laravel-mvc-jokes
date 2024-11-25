<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use App\Models\User;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function home(){
        $totalUsers = User::count();
        $totalJokes = Joke::count();
        $randomJokes = Joke::with('user')->inRandomOrder()->limit(1)->get();
        $members = User::all();
        return view('static.home', compact(['totalUsers'], ['totalJokes'], ['randomJokes'], ['members']));
    }
    public function about(){
        return view('static.about');
    }
    public function contact(){
        return view('static.contact');
    }
}
