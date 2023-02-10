<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allowedCategories = DB::table('user_category AS uc')
                ->select('c.category')
                ->join('categories AS c', 'c.id', '=', 'uc.category_id')
                ->where('user_id', Auth::id())
                ->get();
        
        return view('home', compact('allowedCategories'));
    }
}
