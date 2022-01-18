<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\JoinModel;
use App\Models\ContactUsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class FrontendController extends Controller
{
    public function frontpage()
    {
        $data['divisions'] = CrudModel::findAll('hrm_division', ['status' => 1]);
        $data['university'] = CrudModel::findAll('university', ['status' => 1]);
        $data['board'] = CrudModel::findAll('board', ['status' => 1]);
        $data['exam_name'] = CrudModel::findAll('exam_name', ['status' => 1]);
        return view('auth.register',$data); 
        
    }

    public function getDistricts($divisionId)
    {
        $data = CrudModel::findAll('hrm_district', ['status' => 1,'division_id'=>$divisionId]);
        return $data;
    }
    public function getThanas($districtId)
    {
        $data = CrudModel::findAll('hrm_police_station', ['status' => 1,'district_id'=>$districtId]);
        return $data;
    }

    public function rsave(Request $request)
    {
        //dd($request->all());

           $request->validate([
            'applicant_name'          => 'required',
            'email'         => 'required|email',
        ]);


                      $data = [];
                    $data['applicant_name'] = $request->applicant_name;
                    $data['email'] = $request->email;
                    $data['mailing_address'] = $request->mailing_address;
                    $data['division_id'] = $request->division_id;
                    $data['district_id'] = $request->district_id;
                    $data['ps_id'] = $request->ps_id;
                    $data['address_details'] = $request->address_details;
                    $data['status'] = 1;

                        if(isset($request->photo) && !empty($request->photo))
                        {
                            $photo = time() . Str::random(7) . '.' . $request->photo->extension();
                            $request->photo->move(public_path('images'), $photo);
                            $data['photo'] = $photo;  
                        }

                        if(isset($request->cv) && !empty($request->cv))
                        {
                            $cv = time() . Str::random(7) . '.' . $request->cv->extension();
                            $request->cv->move(public_path('images'), $cv);
                            $data['cv'] = $cv;  
                        }


                DB::beginTransaction();

                try {

                    $data['created_at'] = date('Y-m-d H:i:s');

                    $regId = CrudModel::save('registration',$data);

                    $languageData = [];

                    foreach($request->language as $k => $v)
                    {
                        $languageData[] = [
                        'applicant_id' => $regId,
                        'language_id' => $v,
                        'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }

                    CrudModel::saveBatch('registration_language', $languageData);


                    $educationData = [];

                    foreach($request->exam_id as $k => $v)
                    {
                        $educationData[] = [
                        'applicant_id' => $regId,
                        'exam_id' => $v,
                        'university_id' => $request->university_id[$k],
                        'board_id' => $request->board_id[$k],
                        'result' => $request->result[$k],
                        'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }

                    CrudModel::saveBatch('registration_education', $educationData);

                    $registration_training = [];

                    foreach($request->training_name as $k => $v)
                    {
                        $registration_training[] = [
                        'applicant_id' => $regId,
                        'training_name' => $v,
                        'training_details' => $request->training_details[$k],
                        'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }

                    CrudModel::saveBatch('registration_training', $registration_training);

                    DB::commit();
                   
                } catch (\Exception $e) {
                    DB::rollback();
                    
                }




        return response()->json(['success'=>'Successfully']);

    }


    public function regList()
    {
       $data['regList'] = JoinModel::findAllReg(['registration.status'=>1],['registration.id'=>'desc']);
       return view('backend.registerlist',$data); 
    }




}
