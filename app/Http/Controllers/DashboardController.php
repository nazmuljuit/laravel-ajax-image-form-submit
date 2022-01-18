<?php

namespace App\Http\Controllers;

use App\Models\CrudModel;
use App\Models\JoinModel;

use DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $emp = CrudModel::find('users',['id'=>auth()->user()->id]) ;

        $data['emp'] = $emp;

        return view('dashboard',$data);
    }


}
