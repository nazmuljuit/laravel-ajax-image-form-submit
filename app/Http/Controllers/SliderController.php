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
use App\Models\SlidersModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
	public function listSlider()
    {
    	$data['sliderLists'] = SlidersModel::where('status',1)->get();
    	return view('backend.slider.list',$data);
    }
    public function addSlider()
    {
    	return view('backend.slider.add');
    }
    public function saveSlider(Request $request)
    {

    	$rules = [
    			'title' => 'required|max:255',
                'content' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png',
            ];

            $message = [
            	'title.required' => 'Title is required.',
                'title.max' => 'Title Length exceed.',
                'content.required' => 'Content is required.',
                'image.required' => 'Image is required.',
                'image.mimes' => 'File type is invalid. Please upload jpeg,jpg or png type',
            ];

            $validator = Validator::make($request->all(), $rules, $message);
            if ($validator->fails()){
		        return redirect('/slider/add')
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
    	            $request->image->move(public_path('img/slider'), $image_name);
    	            $postData['image'] = $image_name;
    	        }
    	        //save data in table
    	        SlidersModel::insert($postData);
                DB::commit();
                Alert::toast('Data successfully Inserted', 'success')->width('375px');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not insert successfully','error')->width('570px');
            }
	    	return redirect()->route('slider');
    }
    public function editSlider($id)
    {
    	$data['slider'] =  SlidersModel::find($id);
    	return view('backend.slider.edit',$data);
    }
    public function updateSlider(Request $request)
    {
    	$rules = [
    			'title' => 'required|max:255',
                'content' => 'required',
            ];

            $message = [
            	'title.required' => 'Title is required.',
                'title.max' => 'Title Length exceed.',
                'content.required' => 'Content is required.',
            ];

        if (isset($request->image) && !empty($request->image))
            {
                $rules['image']='mimes:jpeg,jpg,png';
                $message['image.mimes'] = 'File type is invalid. Please upload jpeg,jpg or png type';
            }
            //validation
	        $validator = Validator::make($request->all(), $rules, $message);
	        	if ($validator->fails()){
	                return redirect('/slider/edit/'.$request->get('id'))
	                        ->withErrors($validator)
	                        ->withInput();
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
                    $request->image->move(public_path('img/slider'), $image_name);
                    $postData['image'] = $image_name;
                    //Delete file
                    $image_path = "img/slider/".$request->get('image_name');  // Value is not URL but directory file path
                    if(File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
                //update data
                SlidersModel::where('id',$request->get('id'))->update($postData);
                DB::commit();
                Alert::toast('Data successfully Updated', 'success')->width('375px');
            }catch (\Exception $e) {
                DB::rollback();
                Alert::toast('Data did not update successfully','error')->width('570px');
            }
        return redirect()->route('slider');
    }
    public function deleteSlider($id)
    {
        $data = SlidersModel::find($id);
        $updateData = SlidersModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            //Delete file
            $image_path = "img/slider/".$data->image;  // Value is not URL but directory file path
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
