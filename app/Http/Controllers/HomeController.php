<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;

class HomeController extends Controller
{
    
    public function index()
    {
        $newsMobile = Product::where('title', 'newsMobile')
            ->first();
        $newsDesktop = Product::where('title', 'newsDesktop')
            ->first();
        // $comments = Comment::join('users', 'comments.user_id', '=', 'users.id')
        //     ->where('best', true)
        //     ->select('comments.comment', 'users.name')
        //     ->get();

        $comments = Comment::where('best', 1)
        ->where('status', 1)->get();

        return view('home', compact('newsMobile', 'newsDesktop', 'comments'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function profile()
    {
        return view('profile.user-profile');
    }
    public function banned()
    {
        return view('banned');
    }
}
