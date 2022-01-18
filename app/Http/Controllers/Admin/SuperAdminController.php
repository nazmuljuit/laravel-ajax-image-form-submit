<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrudModel;
use App\Models\JoinModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;


class SuperAdminController extends Controller
{




    public function adminList()
    {

        $data['paginateData'] = DB::table('users')
            ->select('users.*')
            ->orderBy('users.id', 'desc')
            ->paginate(20);
        return view('admin.roles.adminList', $data);
    }

    public function adminCreate()
    {
        return view('admin.roles.adminCreate');
    }

    public function saveAdmin(Request $request)
    {
        if ($request->input('adminId') != NULL) {
            $data['name'] = $request->input('name');
            $data['email'] = $request->input('email');
            $password = $request->input('password');
            if(isset($password) && !empty($password))
            {
                $data['password'] = Hash::make($request->input('password'));
            }
            

            
            if(isset($request->image) && !empty($request->image))
            {

                $image = time() . Str::random(7) . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $image);
                $data['image'] = $image;  

            }

            $id = $request->input('adminId');
            DB::table('users')->where('id', $id)->update($data);
            Alert::toast('Data successfully Updated', 'success')->width('375px');
        }
        else 
        {

            $password = Hash::make($request->input('password'));
            $data = [];
            $data['name'] = $request->input('name');
            $data['email'] = $request->input('email');
            $data['password'] = $password;
            if(isset($request->image) && !empty($request->image))
            {

                $image = time() . Str::random(7) . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $image);
                $data['image'] = $image;  

            }
            
            
            $admin = User::create($data);
            Alert::toast('Data successfully Inserted', 'success')->width('375px');
        }
        return Redirect::to('admin/list');
    }

    public function adminEdit($id)
    {
        $admin = DB::table('users')->where('id', $id)->first();
        return view('admin.roles.adminCreate', compact('admin'));
    }



}
