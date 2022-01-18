<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\FAQModel;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FAQController extends Controller
{
    //
    public function listFAQ()
    {
        $data['faqLists'] = FAQModel::where('status',1)->get();
        return view('backend.faq.list',$data);
    }
    public function addFAQ()
    {
        return view('backend.faq.add');
    }
    public function saveFAQ(Request $request)
    {
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required|max:300',
        ];
        $message = [
            'question.required' => 'Question is required.',
            'question.max' => 'Question Length exceed.',
            'answer.required' => 'Answer is required.',
            'answer.max' => 'Answer Length exceed.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/faq/add')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $postData = $request->except('_token');
            $postData['created_at'] = Carbon::now();
            //save data in table
            FAQModel::insert($postData);
            DB::commit();
            Alert::toast('Data successfully Inserted', 'success')->width('375px');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not insert successfully','error')->width('570px');
        }
        return redirect()->route('faq');
    }
    public function editFAQ($id)
    {
        $data['faq'] =  FAQModel::find($id);
        //dd($data);
        return view('backend.faq.edit',$data);
    }
    public function updateFAQ(Request $request)
    {
        //dd($request->all());
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required|max:300',
        ];
        $message = [
            'question.required' => 'Question is required.',
            'question.max' => 'Question Length exceed.',
            'answer.required' => 'Answer is required.',
            'answer.max' => 'Answer Length exceed.',
        ];

        //validation
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()){
            return redirect('/faq/edit/'.$request->get('id'))
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $postData = $request->except('_token','id');
            $postData['updated_at'] = Carbon::now();
            //update data
            FAQModel::where('id',$request->get('id'))->update($postData);
            DB::commit();
            Alert::toast('Data successfully Updated', 'success')->width('375px');
        }catch (\Exception $e) {
            DB::rollback();
            Alert::toast('Data did not update successfully','error')->width('570px');
        }
        return redirect()->route('faq');
    }
    public function deleteFAQ($id)
    {
        $data = FAQModel::find($id);
        $updateData = FAQModel::where('id',$id)->update(['status'=>0]);
        if($updateData)
        {
            Alert::toast('Data Deleted successfully.','success')->width('375px');
            return response()->json(['status' => 1]);
        }
        else{
            return response()->json(['status' => 0]);
        }
    }
}
