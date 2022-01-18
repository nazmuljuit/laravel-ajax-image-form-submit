<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


use App\Models\CrudModel;
use App\Models\JoinModel;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Redirect;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $checkanyUser = CrudModel::find('users');
        if(!isset($checkanyUser->id))
        {
           return view('auth.register');  
        }
       
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
            $rules = [
                'emp_name' => 'required|max:255',
                'group_id' => ['required',
                                Rule::unique('hrm_employee_info')->where(function ($query) use ($request) {
                                    return $query->where('branch_id', $request->branch_id)
                                                 ->where('emp_att_no', $request->emp_att_no)
                                                 ->where('status', 1);
                                                })],
                'dep_id' => 'required',
                'desi_id' => 'required',
                'branch_id' => 'required',
                'current_salary' => 'required',
                'joining_date' => 'required',
                'mobile_no' => 'required',
                'emp_att_no' => 'required',
            ];

            $message = [
              'required'  => 'The :attribute field is required.',
              'unique'    => ':attribute is already used. Group,Branch,Employee no must be unique!'
            ];

            $this->validate($request, $rules,$message);
            $data = $request->only('emp_name', 'emp_father_name', 'emp_mother_name', 'group_id','dep_id', 'desi_id', 'branch_id', 'current_salary', 'joining_date','mobile_no','job_confirmation_date','emp_code','birth_date','birth_place','emp_blood_group','gender','religion','marital_status','national_id','passport_no','pressent_address','permanent_address','nationality','driving_licence','remarks','emp_att_no','is_honourable');

           // dd($request->is_honourable);

            if ($request->is_honourable=='on'){
                $data['is_honourable']=1;
            }
            else{
                $data['is_honourable']=0;
            }

            $users = $request->only('email');
            if(isset($request->emp_photo) && !empty($request->emp_photo))
            {
                $emp_photo = time().Str::random(7).'.'.$request->emp_photo->extension();
                $request->emp_photo->move(public_path('images'), $emp_photo);
                $data['emp_photo'] = $emp_photo;
            }

            if(isset($request->emp_id) && !empty($request->emp_id))
            {
                $updated_at= Carbon::now();
                $data['updated_at'] = $updated_at;
                $id = $request->emp_id;
                CrudModel::update('hrm_employee_info', $data,['id'=>$id]);
                if(isset($request->password) && !empty($request->password))
                {
                  $users['password']=Hash::make($request->password);
                }

                $users['group_id']=$request->groups;
                CrudModel::update('users', $users,['emp_id'=>$request->emp_id]);
                Alert::toast('Data Successfully Updated','success')->width('375px');
            }
            else
            {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['sys_emp_code'] = $data['group_id'].$data['dep_id'].$data['desi_id'].strtotime("now");
                $users['email']=$request->email;
                $users['group_id']=$request->groups;
                $users['created_at']=$data['created_at'] ;
                $users['password']=Hash::make($request->password);
                $users['name']=$request->emp_name;
                $id = CrudModel::save('hrm_employee_info', $data);
                $users['emp_id']=$id;
                CrudModel::save('users', $users);
                Alert::toast('Data successfully Inserted','success')->width('375px');
            }

        //Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
