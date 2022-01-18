<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\TestimonialsModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TestimonialsController extends Controller
{
    //
    public function testimonialList()
    {
        $data['testimonialLists'] = TestimonialsModel::where('status',1)->get();
        return view('backend.testimonial.list',$data);
    }
    public function addTestimonial()
    {
        return view('backend.testimonial.add');
    }
    public function saveTestimonial(Request $request)
    {
        $rules = [
            'client_name' => 'required|max:255',
            'client_designation' => 'required|max:100',
            'quote' => 'required|max:300',
            'client_image' => 'required|mimes:jpeg,jpg,png',
        ];

        $message = [
            'client_name.required' => 'Name is required.',
            'client_name.max' => 'Name Length exceed.',
            'client_designation.required' => 'Designation is required.',
            'client_designation.max' => 'Designation Length exceed.',
            'quote.required' => 'Quote is required.',
            'quote.max' => 'Quote Length exceed.',
            'client_image.required' => 'Image is required.',
            'client_image.mimes' => 'File type is invalid. Please upload jpeg,jpg or png type',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/testimonial/add')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $postData = $request->except('_token','image');
            $postData['created_at'] = Carbon::now();
            // move file
            if (isset($request->client_image) && !empty($request->client_image)) {
                $image_name = time() . Str::random(7) . '.' . $request->client_image->extension();
                $request->client_image->move(public_path('img/testimonial'), $image_name);
                $postData['client_image'] = $image_name;
            }
            //save data in table
            TestimonialsModel::insert($postData);
            DB::commit();
            Alert::toast('Data successfully Inserted', 'success')->width('375px');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not insert successfully','error')->width('570px');
        }
        return redirect()->route('testimonial');
    }
    public function editTestimonial($id)
    {
        $data['testimonial'] =  TestimonialsModel::find($id);
        //dd($data);
        return view('backend.testimonial.edit',$data);
    }
    public function updateTestimonial(Request $request)
    {
        //dd($request->all());
        $rules = [
            'client_name' => 'required|max:255',
            'client_designation' => 'required|max:100',
            'quote' => 'required|max:300',
        ];

        $message = [
            'client_name.required' => 'Name is required.',
            'client_name.max' => 'Name Length exceed.',
            'client_designation.required' => 'Designation is required.',
            'client_designation.max' => 'Designation Length exceed.',
            'quote.required' => 'Quote is required.',
            'quote.max' => 'Quote Length exceed.',
        ];
        if (isset($request->client_image) && !empty($request->client_image))
        {
            $rules['client_image']='mimes:jpeg,jpg,png';
            $message['client_image.mimes'] = 'File type is invalid. Please upload jpeg,jpg or png type';
        }
        //validation
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/testimonial/edit/'.$request->get('id'))
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $postData = $request->except('_token','image','id','image_name');
            $postData['updated_at'] = Carbon::now();
            // move file  and delete
            if (isset($request->client_image) && !empty($request->client_image)) {
                //move file
                $image_name = time() . Str::random(7) . '.' . $request->client_image->extension();
                $request->client_image->move(public_path('img/testimonial'), $image_name);
                $postData['client_image'] = $image_name;
                //Delete file
                $image_path = "img/testimonial/".$request->get('image_name');  // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            //update data
            TestimonialsModel::where('id',$request->get('id'))->update($postData);
            DB::commit();
            Alert::toast('Data successfully Updated', 'success')->width('375px');
        }catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not update successfully','error')->width('570px');
        }
        return redirect()->route('testimonial');
    }
    public function deleteTestimonial($id)
    {
        $data = TestimonialsModel::find($id);
        $updateData = TestimonialsModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            //Delete file
            $image_path = "img/testimonial/".$data->client_image;  // Value is not URL but directory file path
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
