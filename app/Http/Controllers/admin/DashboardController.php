<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    
    public function index() {
        return view('admin.dashboard.index');
    }
}
