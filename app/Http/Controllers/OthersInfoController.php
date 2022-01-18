<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\OthersInfoModel;
use App\Models\OthersInfoDetailsModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class OthersInfoController extends Controller
{
    //
    public function listOther()
    {
        $data['otherInfoLists'] = OthersInfoModel::where('status',1)->get();
        return view('backend.other-info.list',$data);
    }
    public function addOther()
    {
        return view('backend.other-info.add');
    }
    public function saveOther(Request $request)
    {
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:255',
            'div_name' => 'required|max:100',
        ];

        $message = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title Length exceed.',
            'content.required' => 'Content is required.',
            'content.max' => 'Content Length exceed.',
            'div_name.required' => 'Div Name is required.',
            'div_name.max' => 'Div Name Length exceed.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/other/add')
                ->withErrors($validator)
                ->withInput();
        }
        //$arr[];
        //dd($request->all());
        DB::beginTransaction();
        try {
            $othersInfoModel = new OthersInfoModel();
            $othersInfoModel->title = $request->get('title');
            $othersInfoModel->content = $request->get('content');
            $othersInfoModel->content2 = $request->get('content2');
            $othersInfoModel->div_name = $request->get('div_name');
            $othersInfoModel->created_at = Carbon::now();
            // move file
            if (isset($request->media) && !empty($request->media)) {
                $image_name = time() . Str::random(7) . '.' . $request->media->extension();
                $request->media->move(public_path('img/other'), $image_name);
                $othersInfoModel->media = $image_name;
            }
            //save data in table
            $othersInfoModel->save();
            $last_id=$othersInfoModel->id;
            //save data in second table
            $arr =[];
            foreach ($request->get('arr') as $key=>$value)
            {
                if($value['question'] != null)
                {
                    $arr[$key]['others_info_id'] = $last_id;
                    $arr[$key]['question'] = $value['question'];
                    $arr[$key]['answer'] = $value['answer'];
                    $arr[$key]['created_at'] = Carbon::now();
                }
            }
            if($arr)
            {
                OthersInfoDetailsModel::insert($arr);
            }

            DB::commit();
            Alert::toast('Data successfully Inserted', 'success')->width('375px');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not insert successfully','error')->width('570px');
        }
        return redirect()->route('other');
    }

    public function editOther($id)
    {
        $data['otherInfo'] =  OthersInfoModel::find($id);
        //dd($data);
        return view('backend.other-info.edit',$data);
    }
    public function updateOther(Request $request)
    {
       // dd($request->all());
        $rules = [
            'title' => 'required|max:100',
            'content' => 'required|max:255',
            'div_name' => 'required|max:100',
        ];

        $message = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title Length exceed.',
            'content.required' => 'Content is required.',
            'content.max' => 'Content Length exceed.',
            'div_name.required' => 'Div Name is required.',
            'div_name.max' => 'Div Name Length exceed.',
        ];

        //validation
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/other/edit/'.$request->get('id'))
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $postData = $request->except('_token','media','id');
            $postData['updated_at'] = Carbon::now();
            // move file  and delete
            if (isset($request->media) && !empty($request->media)) {
                //move file
                $image_name = time() . Str::random(7) . '.' . $request->media->extension();
                $request->media->move(public_path('img/other'), $image_name);
                $postData['media'] = $image_name;
                //Delete file
                $image_path = "img/other/".$request->get('image_name');  // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            //update data
            OthersInfoModel::where('id',$request->get('id'))->update($postData);
            DB::commit();
            Alert::toast('Data successfully Updated', 'success')->width('375px');
        }catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not update successfully','error')->width('570px');
        }
        return redirect()->route('other');
    }
    public function viewOther($id)
    {
        $othersInfoModel = new OthersInfoModel();
        $data['viewAll'] = $othersInfoModel->getData($id);
        $data['title'] = $data['viewAll'][0]->title;
        $data['content'] = $data['viewAll'][0]->content;
        $data['details'] = $data['viewAll'][0]->content2;
        $data['divName'] = $data['viewAll'][0]->div_name;
        $data['image'] = $data['viewAll'][0]->media;
        //dd($data);
        return view('backend.other-info.view',$data);
    }
    public function deleteOther($id)
    {
        $data = OthersInfoModel::find($id);
        $updateData = OthersInfoModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            //Delete file
            $image_path = "img/other/".$data->client_image;  // Value is not URL but directory file path
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
