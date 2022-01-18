<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use App\Models\CrudModel;
use Carbon\Carbon;

class ExcelImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public $data;
    protected $imdata;

     public function  __construct($imdata)
    {
        $this->imdata = $imdata;
    }

    public function collection(Collection $collection)
    {
        
        $batchData = [];
        foreach($collection as $k=>$row) 
        {
            //dd($row);
            if($k > 0)
            {
                if(isset($row[9]) && !empty($row[9] && $row[10]) && !empty($row[10]))
                {
                    $batchData[] = [
                    'emp_att_no' => $row[1],
                    'att_date' => Carbon::parse($row[5])->format('Y-m-d'),
                    'sign_in' => $row[9],
                    'sign_out' => $row[10],
                    'group_id' => $this->imdata['group_id'],
                    'branch_id' => $this->imdata['branch_id'],
                    'device_id' => $this->imdata['device_id'],
                    ];  
                }


            }

            
        }

        //dd($batchData);
       $att_data = CrudModel::findAll('hrm_attendance',['group_id'=>$this->imdata['group_id'],'branch_id'=>$this->imdata['branch_id']]);

        $empIpList = JoinModel::findEmpWiseIp(['hrm_employee_info.group_id'=>$this->imdata['group_id'],'hrm_employee_info.branch_id'=>$this->imdata['branch_id']],['hrm_employee_info.id'=>'asc']);
        $deviceWiseAttno = [];
        $empWiseAttno = [];
        foreach($empIpList as $key=>$val)
        {
            if(isset($val->device_id) && !empty($val->device_id))
            {
                if($val->emp_att_no != 0)
                {
                 $deviceWiseAttno[$val->device_id][$val->emp_att_no] = $val->id;   
                }
                
            }
            else
            {
                if(isset($val->att_no) && !empty($val->att_no))
                {
                    $empWiseAttno[$val->att_no] = $val->id;
                }

            }




        }
       $finalBatchData = [];

       foreach($batchData as $k => $v)
       {
        if (isset($att_data) && !empty($att_data)) 
        {
            foreach($att_data as $i => $av)
            {
                if($av->att_date == $v['att_date'] && $av->group_id == $v['group_id'] && $av->branch_id == $v['branch_id'] )
                {

                    if($av->device_id == $v['device_id'] && $av->emp_att_no == $v['emp_att_no'])
                    {
                        //excel upload
                        continue 2;
                    }
                    else if($av->device_id == 0 && $av->emp_id == 0) 
                    {
                        //old upload
                        if($av->emp_att_no == $v['emp_att_no'])
                        {
                            continue 2;
                        }
                    }
                    else if($av->emp_att_no == 0 && $av->device_id == 0)
                    {
                         //new from machine data or manual
                        if(isset($deviceWiseAttno[$v['device_id']][$v['emp_att_no']]) && !empty($deviceWiseAttno[$v['device_id']][$v['emp_att_no']]))
                        {
                            //new update
                            continue 2;
                        }
                        else if(isset($empWiseAttno[$v['emp_att_no']]) && !empty($empWiseAttno[$v['emp_att_no']]))
                        {
                            //old version
                            continue 2;
                        }

                    } 
                }

            }
        }

            $finalBatchData[] = [
            'emp_att_no' => $v['emp_att_no'],
            'att_date' => $v['att_date'],
            'sign_in' => $v['sign_in'],
            'sign_out' => $v['sign_out'],
            'group_id' => $v['group_id'],
            'branch_id' => $v['branch_id'],
            'device_id' => $v['device_id'],
            'created_at' => date('Y-m-d H:i:s'),
            ];

       }



       if (isset($finalBatchData) && !empty($finalBatchData)) 
       {
           CrudModel::saveBatch('hrm_attendance', $finalBatchData);
       }
       
      
         //$this->data = $batchData;

       
    }
}
