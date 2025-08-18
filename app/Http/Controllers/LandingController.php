<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Redirect ke dashboard jika user sudah login
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        
        return view('landing');
    }
}