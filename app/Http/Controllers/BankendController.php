<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\JoinModel;
use App\Models\ContactUsModel;
use App\Models\TeamsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class BankendController extends Controller
{
    public function serviceList()
    {
        $data['services'] = CrudModel::findAll('our_services',['status'=>1]);
        return view('backend.service',$data);
    }

    public function serviceCreate()
    {
        return view('backend.service-create');
    }

    public function serviceSave(Request $request)
    {
        //dd($request->all());
 
            $rules = [
                'service_name' => 'required|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'content' => 'required',
                'icon' => 'required',
            ];

      

        $message = [
            'service_name.required' => 'Service Name field is required.',
            'image' => 'image is not match.',
            'content.required' => 'Content is required.',
            'icon.required' => 'Icon is required.',
        ];
        $this->validate($request, $rules, $message);
        $data = $request->only('service_name','content','icon');
        if(isset($request->image) && !empty($request->image))
        {
            $image = time() . Str::random(7) . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $image);
            $data['image'] = $image;  
        }

        if(isset($request->serviceId) && !empty($request->serviceId))
        {
            CrudModel::update('our_services', $data, ['id' => $request->serviceId]);
        }
        else
        {
            CrudModel::save('our_services', $data);
        }
        
        Alert::toast('Data successfully Inserted', 'success')->width('375px');
        return redirect()->route('service.list');


    }

    public function serviceEdit($id)
    {
        $data['services'] = CrudModel::find('our_services',['id'=>$id]);
        return view('backend.service-create',$data);
    }

    public function serviceDelete($id)
    {
    

            /*data delete*/
            $data['status'] = 0;
            CrudModel::update('our_services',$data,['id'=>$id]);


            Alert::toast('Data Deleted successfully.','success')->width('375px');
            return response()->json(['status' => 1]);

       
    }
    public function contactUsList()
    {
    	$data['contactUsLists'] = ContactUsModel::where('status',1)->get();
    	return view('backend.contact-us-list',$data);
    }
    public function teamList()
    {
    	$data['teamMemberLists'] = TeamsModel::where('status',1)->get();
    	return view('backend.team.list',$data);
    }
    public function addTeamMember()
    {
    	return view('backend.team.add');
    }
    public function saveTeamMember(Request $request)
    {
    	$rules = [
                'name' => 'required|max:255',
                'designation' => 'required|max:100',
                'image' => 'required|mimes:jpeg,jpg,png',
            ];

            $message = [
                'name.required' => 'Name is required.',
                'name.max' => 'Name Length exceed.',
                'designation.required' => 'Designation is required.',
                'designation.max' => 'Designation Length exceed.',
                'image.required' => 'Image is required.',
                'image.mimes' => 'File type is invalid. Please upload jpeg,jpg or png type',
            ];

            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()){
		        return redirect('/team/add')
                        ->withErrors($validator)
                        ->withInput();
        		}
            DB::beginTransaction();
            try {
    	    	$postData = $request->except('_token','image');
    	    	$postData['created_at'] = Carbon::now();
    	    	// move file 
    	    	if (isset($request->image) && !empty($request->image)) {
    	            $image_name = time() . Str::random(7) . '.' . $request->image->extension();
    	            $request->image->move(public_path('img/team'), $image_name);
    	            $postData['image'] = $image_name;
    	        }
    	        //save data in table
    	        TeamsModel::insert($postData);
                DB::commit();
                Alert::toast('Data successfully Inserted', 'success')->width('375px');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not insert successfully','error')->width('570px');
            }
	    	return redirect()->route('team');
    }
    public function editTeamMember($id)
    {
    	$data['team'] =  TeamsModel::find($id);
    	return view('backend.team.edit',$data);
    }
    public function updateTeamMember(Request $request)
    {
        $rules = [
                'name' => 'required|max:255',
                'designation' => 'required|max:100',
            ];

        $message = [
                'name.required' => 'Name is required.',
                'name.max' => 'Name Length exceed.',
                'designation.required' => 'Designation is required.',
                'designation.max' => 'Designation Length exceed.',
            ];
            if (isset($request->image) && !empty($request->image))
            {
                $rules['image']='mimes:jpeg,jpg,png';
                $message['image.mimes'] = 'File type is invalid. Please upload jpeg,jpg or png type';
            }
            //validation
        $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()){
                return redirect('/team/edit/'.$request->get('id'))
                        ->withErrors($validator)
                        ->withInput();
                }
        DB::beginTransaction();
            try {
                $postData = $request->except('_token','image','id','image_name');
                $postData['updated_at'] = Carbon::now();
                // move file  and delete
                if (isset($request->image) && !empty($request->image)) {
                    //move file
                    $image_name = time() . Str::random(7) . '.' . $request->image->extension();
                    $request->image->move(public_path('img/team'), $image_name);
                    $postData['image'] = $image_name;
                    //Delete file
                    $image_path = "img/team/".$request->get('image_name');  // Value is not URL but directory file path
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
                //update data
                TeamsModel::where('id',$request->get('id'))->update($postData);
                DB::commit();
                Alert::toast('Data successfully Updated', 'success')->width('375px');
            }catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not update successfully','error')->width('570px');
            }
        return redirect()->route('team');
    }
    public function deleteTeamMember($id)
    {
        $data = TeamsModel::find($id);
        $updateData = TeamsModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            //Delete file
            $image_path = "img/team/".$data->image;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            Alert::toast('Data Deleted successfully.','success')->width('375px');
            return response()->json(['status' => 1]);
        }
        else{
            return response()->json(['status' => 0]);
        }
    }
}
