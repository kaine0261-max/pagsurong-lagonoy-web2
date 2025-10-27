<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Home Page
    public function index()
    {
        return view('home');
    }

    // About Page - Redirect to home with anchor
    public function about()
    {
        return redirect('/#about');
    }

    // Contact Page - Redirect to home with anchor
    public function contact()
    {
        return redirect('/#contact');
    }

    // Resorts Page
    public function resorts()
    {
        return view('resorts');
    }

    // Tourist Attractions Page
    public function attractions()
    {
        return view('attractions');
    }
}