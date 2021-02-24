<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meetings;
use App\Models\Configurations;

class MeetingsController extends Controller
{
    public function index() {
        $meetings = Meetings::paginate(Configurations::getByKey('default_page_size'));
        return view('admin.meetings.index', ['meetings' => $meetings]);
    }
}
