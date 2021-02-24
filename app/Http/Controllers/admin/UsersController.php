<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configurations;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $users = User::paginate(Configurations::getByKey('default_page_size'));
        
        return view('admin.users.index', ['users' => $users]);
    }
    
    public function add() {
        
        return view('admin.users.add');
    }
}
