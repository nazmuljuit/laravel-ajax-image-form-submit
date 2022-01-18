<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\EmployeeInformationsModel;
use App\Models\GroupsModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['employee'] = EmployeeInformationsModel::where(['status' => 1])->get();
        $groupsModel = new GroupsModel();
        $data['companies'] = $groupsModel->getData();
        //dd($data['companies']);
        //$data['company'] = CrudModel::find('company',['status'=>1]);
        return view('settings.company.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->companyId) && !empty($request->companyId))
        {
            $rules = [
                'company_name' => 'required|max:255',
                'company_email' => 'required|max:80',
                'company_phone' => 'required|max:20',
                'head_office' => 'required',
            ];
        }
        else
        {
            $rules = [
                'company_name' => 'required|max:255',
                'company_email' => 'required|max:80',
                'company_phone' => 'required|max:20',
                'head_office' => 'required',
                'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'company_favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
        $message = [
            'company_name.required' => 'Company name field is required.',
            'company_email.required' => 'Company Email field is required.',
            'company_phone.required' => 'Company Phone field is required.',
            'head_office.required' => 'Head Office field is required.',
            'company_logo.required' => 'Company logo is required.',
            'company_favicon.required' => 'Company favicon is required.',
        ];
        $this->validate($request, $rules, $message);
        $data = $request->only('company_name', 'company_email', 'company_phone', 'head_office');
        if(isset($request->company_logo) && !empty($request->company_logo))
        {
            $company_logo = time().Str::random(7).'.'.$request->company_logo->extension();
            $request->company_logo->move(public_path('images'), $company_logo);
            $data['company_logo'] = $company_logo;

        }

        if(isset($request->company_favicon) && !empty($request->company_favicon))
        {
            $company_favicon = time().Str::random(7).'.'.$request->company_favicon->extension();
            $request->company_favicon->move(public_path('images'), $company_favicon);
            $data['company_favicon'] = $company_favicon;
        }
        if(isset($request->companyId) && !empty($request->companyId))
        {
            $data['updated_at'] = Carbon::now();
            CrudModel::update('company', $data,['id'=>$request->companyId]);
            $logData['updated_at'] = $data['updated_at'];
            $logData['user_id'] = auth()->user()->id;
            $logData['table_name'] = 'company';
            $logData['url'] = 'companys';
            $logData['event'] = 'company stored';
            $logData['data'] = json_encode($data);
            $logData['details'] = 'company updated by'.auth()->user()->name;
            CrudModel::save('user_log', $logData);
            Alert::toast('Data Successfully Updated','success')->width('375px');
        }
        else
        {
            $data['created_at'] = Carbon::now();
            CrudModel::save('company', $data);
            $logData['created_at'] = $data['created_at'];
            $logData['user_id'] = auth()->user()->id;
            $logData['table_name'] = 'company';
            $logData['url'] = 'companys';
            $logData['event'] = 'company stored';
            $logData['data'] = json_encode($data);
            $logData['details'] = 'company created by'.auth()->user()->name;
            CrudModel::save('user_log', $logData);
            Alert::toast('Data successfully Inserted','success')->width('375px');
        }
        return redirect()->route('companys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      echo "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['employee'] = EmployeeInformationsModel::where(['status' => 1])->get();
        $data['company'] = CrudModel::find('company',['id'=>$id]);
        return view('settings.company.create',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

    }
    public function updateGroup(Request $request)
    {
        //dd($request->all());
        $postData = $request->except('_token', 'companyId');
        if (!isset($request->is_last_month_days))
        {
            $postData['is_last_month_days'] = 0;
        }
        //get designation
        $designation = EmployeeInformationsModel::find($request->get('head_id'));
        if($designation)
        {
            $postData['head_desi_id'] = $designation->desi_id;
            $postData['updated_at'] = Carbon::now();
        }
        $updateGroup = GroupsModel::where('id',$request->get('companyId'))->update($postData);
        if($updateGroup)
        {
            Alert::toast('Data Successfully Updated', 'success')->width('375px');
            return redirect('companys');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
