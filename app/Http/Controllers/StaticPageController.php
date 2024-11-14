<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function home(){
        return view('static.home');
    }
    public function about(){
        return view('static.about');
    }
    public function contact(){
        return view('static.contact');
    }
}
