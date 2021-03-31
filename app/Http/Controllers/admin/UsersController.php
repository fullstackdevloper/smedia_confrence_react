<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configurations;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserMeta;
use App\Mail\ExpertInvites;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
class UsersController extends Controller
{
    public function index() {
        $users = User::paginate(Configurations::getByKey('default_page_size'));
        
        return view('admin.users.index', ['users' => $users]);
    }
    
    public function add() {
        
        return view('admin.users.add');
    }
    
    public function delete(Request $request, $user_id) {
        $user = User::find($user_id); 
        if(User::isLastAdmin($user)) {
            return redirect('/admin/users')->with('error', __("Can't delete this user. At least one Admin is required."));
        }
        
        /*if($user->delete()) {
            return redirect('/admin/users')->with('success', __('User is deleted from database.'));
        }*/
    }

    public function expert()
    {
        return view('admin.expert.create_expert');
    }

    public function create_expert(Request $request)
    {
        $input = $request->all();
        

        $v = Validator::make($request->all(), [
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'        => ['required', 'string', 'min:8'],
            'title'           => ['required', 'string', 'max:255'],
            'bio'             => ['required', 'string', 'max:255']
        ]);
        if ($v->fails()) {
            return redirect()
            ->back()->withInput($request->input())
            ->withErrors($v->errors());
        }
        $profileImage = $input['profile_picture'];
        $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();
        // $upload_path = 'profile_images/';
        $upload_path       = public_path('/profile_images/');
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);
      



        $userData = [
            'name'                    => $input['name'],
            'email'                   => $input['email'],
            'password'                => Hash::make($input['password']),
            'personal_meet_id'        => '0',
            'role'                    => 'expert'
        ];
        $expertInsert = User::create($userData);
        // Mail::to($userData['email'])->send(new ExpertInvites($userData));
        $request->request->add(['profile_image' => $profileImageSaveAsName]);
        foreach ($request->except('_token', 'name','password', 'email','profile_picture') as $key => $value) {
        $userMeta = [
            'user_id'         =>$expertInsert->id,
            'key'             =>$key,
            'value'           =>$value
        ];
        UserMeta::create($userMeta);
    }

    $request->session()->flash('alert-success', 'successful added!');
    return redirect()->to('/admin/expert')->with('success','Successfully Added');
    }

    public function expert_view()
    {
        $products = User::with('UserMeta')->where('role','expert')->orderBy('id', 'DESC')->get();
        $data = [
            'expertAll' => $products
        ];
        return view('admin.expert.expert_table',$data);
    }

    public function destroy($id)
    {
        $data =DB::table('users')
        ->leftJoin('user_meta','users.id', '=','user_meta.user_id')
        ->where('users.id', $id); 
        DB::table('user_meta')->where('user_id', $id)->delete();                           
        $data->delete();
        return redirect()->to('/admin/expert');
    }
}
