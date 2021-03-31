<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configurations;

class SettingsController extends Controller
{
    public function index(Request $request) {
        $input = $request->all();
        if($input) {
            foreach ($input['settings'] as $key => $value) {
                Configurations::updateConfiguration($key, $value);
            }
            
            return redirect("admin/settings");
        }
        $config = Configurations::getAll();
        
        return view('admin.settings.index', ['config' => $config]);
    }
    
    public function api_settings(Request $request) {
        $input = $request->all();
        if($input) {
            foreach ($input['api_settings'] as $key => $value) {
                Configurations::updateConfiguration($key, $value);
            }
            
            return redirect("admin/settings/apisettings");
        }
        
        return view('admin.settings.api_settings');
    }
}
