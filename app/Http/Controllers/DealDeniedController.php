<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;

class DealDeniedController extends Controller
{
    public function index()
    {
        return view('gateway.deal-denied');
    }
    
}