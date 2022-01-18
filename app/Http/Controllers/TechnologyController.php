<?php
/**
 * Shampan IT Solutions
 * Copyright (C) 2021 ShampanIT <info@shampanit.com>
 *
 * @category ShampanIT
 * @package Shampan_IT
 * @copyright Copyright (c) 2021 ShampanIT (http://www.shampanit.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author ShampanIT <info@shampanit.com>
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TechnologiesModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class TechnologyController extends Controller
{
    public function listTechnology()
    {
    	$data['technologyLists'] = TechnologiesModel::where('status',1)->get();
    	return view('backend.technology.list',$data);
    }
    public function addTechnology()
    {
    	return view('backend.technology.add');
    }
    public function saveTechnology(Request $request)
    {
    	$rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];

            $message = [
                'image.required' => 'Image is required.',
                'image.mimes' => 'File type is invalid. Please upload jpeg,jpg or png type',
            ];

            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()){
		        return redirect('/technology/add')
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
    	            $request->image->move(public_path('img/technology'), $image_name);
    	            $postData['image'] = $image_name;
    	        }
    	        //save data in table
    	        TechnologiesModel::insert($postData);
                DB::commit();
                Alert::toast('Data successfully Inserted', 'success')->width('375px');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not insert successfully','error')->width('570px');
            }
	    	return redirect()->route('technology');
    }
    public function editTechnology($id)
    {
    	$data['technology'] =  TechnologiesModel::find($id);
    	return view('backend.technology.edit',$data);
    }
    public function updateTechnology(Request $request)
    {
        if (isset($request->image) && !empty($request->image))
            {
                $rules['image']='mimes:jpeg,jpg,png';
                $message['image.mimes'] = 'File type is invalid. Please upload jpeg,jpg or png type';

                //validation
	        	$validator = Validator::make($request->all(), $rules, $message);
	            if ($validator->fails()){
	                return redirect('/technology/edit/'.$request->get('id'))
	                        ->withErrors($validator)
	                        ->withInput();
	                }
            }
            //dd($request->all());
        DB::beginTransaction();
            try {
                $postData = $request->except('_token','image','id','image_name');
                $postData['updated_at'] = Carbon::now();
                // move file  and delete
                if (isset($request->image) && !empty($request->image)) {
                    //move file
                    $image_name = time() . Str::random(7) . '.' . $request->image->extension();
                    $request->image->move(public_path('img/technology'), $image_name);
                    $postData['image'] = $image_name;
                    //Delete file
                    $image_path = "img/technology/".$request->get('image_name');  // Value is not URL but directory file path
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
                //update data
                TechnologiesModel::where('id',$request->get('id'))->update($postData);
                DB::commit();
                Alert::toast('Data successfully Updated', 'success')->width('375px');
            }catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not update successfully','error')->width('570px');
            }
        return redirect()->route('technology');
    }
    public function deleteTechnology($id)
    {
        $data = TechnologiesModel::find($id);
        $updateData = TechnologiesModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            //Delete file
            $image_path = "img/technology/".$data->image;  // Value is not URL but directory file path
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
