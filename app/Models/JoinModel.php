<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JoinModel
{

    public static function findOtherInfo($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('others_info')
            ->select('others_info.*', 'others_info_details.question', 'others_info_details.answer')
            ->leftJoin('others_info_details', 'others_info_details.others_info_id', '=', 'others_info.id');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllReg($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('registration')
            ->select('registration.*', 'hrm_division.division_name', 'hrm_district.district_name', 'hrm_police_station.ps_name')
            ->leftJoin('hrm_division', 'hrm_division.id', '=', 'registration.division_id')
            ->leftJoin('hrm_district', 'hrm_district.id', '=', 'registration.district_id')
            ->leftJoin('hrm_police_station', 'hrm_police_station.id', '=', 'registration.ps_id');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllGroup($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('group')
            ->select('group.*')
            ->where('group.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllDepartment($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('department')
            ->select('department.*', 'group.group_name')
            ->leftJoin('group', 'group.id', '=', 'department.group_id')
            ->where('department.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllDistrict($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_district')
            ->select('hrm_district.*', 'hrm_division.division_name')
            ->leftJoin('hrm_division', 'hrm_division.id', '=', 'hrm_district.division_id')
            ->where('hrm_district.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllPolicestation($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_police_station')
            ->select('hrm_police_station.*', 'hrm_district.district_name', 'hrm_division.id AS divisionId')
            ->leftJoin('hrm_district', 'hrm_district.id', '=', 'hrm_police_station.district_id')
            ->leftJoin('hrm_division', 'hrm_division.id', '=', 'hrm_district.division_id')
            ->where('hrm_police_station.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findDistrict($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_district')
            ->select('hrm_district.*', 'hrm_division.division_name')
            ->leftJoin('hrm_division', 'hrm_division.id', '=', 'hrm_district.division_id')
            ->where('hrm_district.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }

    public static function findPolicestation($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_police_station')
            ->select('hrm_police_station.*', 'hrm_district.district_name')
            ->leftJoin('hrm_district', 'hrm_district.id', '=', 'hrm_police_station.district_id')
            ->where('hrm_police_station.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }






    public static function findAllDesignation($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('designation_info')
            ->select('designation_info.*', 'group.group_name', 'department.dep_name')
            ->leftJoin('group', 'group.id', '=', 'designation_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'designation_info.dep_id')
            ->where('designation_info.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllBankBranch($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_bank_branch')
            ->select('ac_bank_branch.*', 'ac_bank_info.bank_name', 'hrm_district.district_name','hrm_police_station.ps_name')
            ->leftJoin('ac_bank_info', 'ac_bank_info.id', '=', 'ac_bank_branch.bank_id')
            ->leftJoin('hrm_district', 'hrm_district.id', '=', 'ac_bank_branch.district_id')
            ->leftJoin('hrm_police_station', 'hrm_police_station.id', '=', 'ac_bank_branch.ps_id')
            ->where('ac_bank_branch.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllShift($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_shift_info')
            ->select('hrm_shift_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_shift_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_shift_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_shift_info.desi_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_shift_info.branch_id')
            ->where('hrm_shift_info.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAviewShift($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_shift_info')
            ->select('hrm_shift_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_shift_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_shift_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_shift_info.desi_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_shift_info.branch_id')
            ->where('hrm_shift_info.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }




    public static function findAllLate($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_late_settings')
            ->select('hrm_late_settings.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_late_settings.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_late_settings.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_late_settings.desi_id')
            ->where('hrm_late_settings.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findMonthlySalary($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_monthly_salary_generate')
            ->select('ac_monthly_salary_generate.*', 'group.group_name','hrm_employee_info.emp_name','hrm_employee_info.middle_name','hrm_employee_info.last_name','designation_info.desi_name','hrm_employee_info.desi_id','hrm_employee_info.dep_id','hrm_employee_info.joining_date','hrm_employee_info.bank_account_no')
            ->leftJoin('group', 'group.id', '=', 'ac_monthly_salary_generate.group_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'ac_monthly_salary_generate.emp_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('ac_monthly_salary_generate.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllWeekend($where = [], $orderBy = [], $groupBy = [])
    {
        // DB::enableQueryLog();
        $query = DB::table('hrm_weekend_info')
            ->select('hrm_weekend_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_weekend_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_weekend_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_weekend_info.desi_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_weekend_info.branch_id')
            ->whereNull('hrm_weekend_info.emp_id');
        //->where('hrm_weekend_info.status',1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        //dd(DB::getQueryLog());
        return $query->get();
    }

    public static function findAllAnnualLeave($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_anual_leave')
            ->select('hrm_anual_leave.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_anual_leave.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_anual_leave.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_anual_leave.desi_id');
        //  ->where('hrm_anual_leave.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllEmployee($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }


    public static function findAllWithOutHonourEmployee($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.is_honourable', 0)
            ->where('hrm_employee_info.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findAllEmplleave($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.*', 'department.*', 'designation_info.*', 'branch.*')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }



    public static function findempleave($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_emp_leave')
            ->select('hrm_emp_leave.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name','hrm_employee_info.emp_name','hrm_employee_info.middle_name', 'hrm_employee_info.last_name','hrm_employee_info.group_id','hrm_employee_info.dep_id','hrm_employee_info.desi_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_emp_leave.emp_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_emp_leave.id', $id);
        if (!empty($where)) $query->where($where);
        return $query->first();
    }

    public static function findAllPaginateEmployee($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }

        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->paginate(1);
    }

    public static function findAllExtended($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_as_extended')
            ->select('hrm_as_extended.*', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name', 'department.dep_name')
            //  ->leftJoin('group', 'group.id', '=', 'hrm_as_extended.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_as_extended.dep_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_as_extended.emp_id')
            ->where('hrm_as_extended.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findEmployee($where = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*','hrm_division.division_name as present_division_name','hrm_district.district_name as present_district_name','hrm_police_station.ps_name as present_ps_name','permanent_division.division_name as permanent_division_name','permanent_district.district_name as permanent_district_name','permanent_police_station.ps_name as permanent_ps_name','group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name', 'users.email', 'users.password','users.group_id as groupid', 'group.group_favicon', 'group.office_address')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('users', 'users.emp_id', '=', 'hrm_employee_info.id')
            ->leftJoin('hrm_division', 'hrm_employee_info.present_division_id','=','hrm_division.id' )
            ->leftJoin('hrm_district', 'hrm_employee_info.present_district_id','=','hrm_district.id' )
            ->leftJoin('hrm_police_station', 'hrm_employee_info.present_ps_id','=','hrm_police_station.id' )
            ->leftJoin('hrm_division as permanent_division', 'hrm_employee_info.permanent_division_id','=','permanent_division.id' )
            ->leftJoin('hrm_district as permanent_district', 'hrm_employee_info.permanent_district_id','=','permanent_district.id' )
            ->leftJoin('hrm_police_station as permanent_police_station', 'hrm_employee_info.permanent_ps_id','=','permanent_police_station.id' );
        if (!empty($where)) $query->where($where);
        return $query->first();
    }
    public static function findtaskanswer($id,$where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_task_questions')
            ->select('hrm_task_questions.*', 'hrm_daily_report_details.*')
            ->leftJoin('hrm_daily_report_details', 'hrm_daily_report_details.question_id', '=', 'hrm_task_questions.id')
            ->where('hrm_task_questions.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get()->first();
    }

    public static function findEmployees($data)
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->whereIn('hrm_employee_info.id', $data);

        return $query->get();
    }

    public static function findAllLeave($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_leave_info')
            ->select('hrm_leave_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'hrm_leave.leave_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_leave_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_leave_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_leave_info.desi_id')
            ->leftJoin('hrm_leave', 'hrm_leave.id', '=', 'hrm_leave_info.leave_ids')
            ->where('hrm_leave_info.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }



    public static function findAllEmployeeLeave($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_emp_leave')
            ->select('hrm_emp_leave.*', 'hrm_leave.leave_name', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name')
            ->leftJoin('hrm_leave', 'hrm_leave.id', '=', 'hrm_emp_leave.leave_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_emp_leave.emp_id')
            ->where('hrm_emp_leave.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllTaskQues($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_task_questions')
            ->select('hrm_task_questions.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_task_questions.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_task_questions.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_task_questions.desi_id')
            ->where('hrm_task_questions.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllAttendance($where = [],$orderBy=[])
    {
        $query = DB::table('hrm_attendance')
            ->select('hrm_attendance.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name', 'hrm_employee_info.emp_name', 'hrm_employee_info.emp_code', 'hrm_employee_info.mobile_no', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name')
            ->leftJoin('hrm_employee_info', function ($join) {
                $join->on('hrm_attendance.emp_att_no', '=', 'hrm_employee_info.emp_att_no');
                $join->on('hrm_attendance.group_id', '=', 'hrm_employee_info.group_id');
                $join->on('hrm_attendance.branch_id', '=', 'hrm_employee_info.branch_id');
            })
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        return $query->get();
    }

    public static function findempattend1($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_attendance')
            ->select('hrm_attendance.*', 'hrm_employee_info.*')
            ->leftJoin('hrm_employee_info', function ($join) {
                $join->on('hrm_attendance.emp_att_no', '=', 'hrm_employee_info.emp_att_no');
                $join->on('hrm_attendance.group_id', '=', 'hrm_employee_info.group_id');
                $join->on('hrm_attendance.branch_id', '=', 'hrm_employee_info.branch_id');
            });

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->limit(60)->get();
    }

    public static function findempattend($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_attendance')
            ->select('hrm_attendance.*', 'hrm_employee_info.*','hrm_emp_device.emp_id as empId','hei.emp_name as fname','hei.middle_name as mname','hei.last_name as lname','empInfo.emp_name as finame','empInfo.middle_name as miname','empInfo.last_name as laname')
            ->leftJoin('hrm_employee_info', function ($join) {
                $join->on('hrm_attendance.emp_id', '=', 'hrm_employee_info.id');
                $join->where('hrm_attendance.device_id', '=', 0);
                $join->where('hrm_attendance.emp_att_no', '=', 0);
                $join->where('hrm_attendance.emp_id', '>', 0);
            })
            ->leftJoin('hrm_emp_device', function ($join) {
                $join->on('hrm_attendance.device_id', '=', 'hrm_emp_device.device_id');
                $join->on('hrm_attendance.emp_att_no', '=', 'hrm_emp_device.emp_att_no');
                $join->leftJoin('hrm_employee_info as hei', function ($join) {
                   $join->on('hrm_emp_device.emp_id', '=', 'hei.id'); 
                });
                $join->where('hrm_attendance.device_id', '>', 0);
                $join->where('hrm_attendance.emp_att_no', '>', 0);
            })
            ->leftJoin('hrm_employee_info as empInfo', function ($join) {
                $join->on('hrm_attendance.emp_att_no', '=', 'empInfo.emp_att_no');
                $join->on('hrm_attendance.group_id', '=', 'empInfo.group_id');
                $join->on('hrm_attendance.branch_id', '=', 'empInfo.branch_id');
                $join->where('hrm_attendance.emp_id', '=', 0);
                $join->where('hrm_attendance.emp_att_no', '>', 0);
            });

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->limit(60)->get();
    }

    public static function findAlldailyReportDetails($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_daily_report_details')
            ->select('hrm_daily_report_details.*', 'hrm_daily_report.date', 'hrm_employee_info.emp_name', 'hrm_task_questions.question')
            ->leftJoin('hrm_daily_report', 'hrm_daily_report.id', '=', 'hrm_daily_report_details.dr_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_daily_report.emp_id')
            ->leftJoin('hrm_task_questions', 'hrm_task_questions.id', '=', 'hrm_daily_report_details.question_id');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }



    public static function findEventDetails($id)
    {
        $query = DB::table('hrm_event')
            ->select('hrm_event.*', 'hrm_employee_info.emp_name', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'hrm_event_emp.group_id', 'hrm_event_emp.desi_id', 'hrm_event_emp.dep_id', 'hrm_event_emp.emp_id')
            ->leftJoin('hrm_event_emp', 'hrm_event.id', '=', 'hrm_event_emp.event_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_event_emp.group_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_event_emp.desi_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_event_emp.dep_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_event_emp.emp_id')
            ->where('hrm_event.id', $id);
        return $query->get();

    }

    public static function findAllNotice($id,$where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_notice')
            ->select('hrm_notice.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'hrm_employee_info.*','hrm_notice_details.*')
            ->leftJoin('hrm_notice_details', 'hrm_notice_details.notice_id', '=', 'hrm_notice.id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_notice_details.emp_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_notice.id', $id)
            ->where('hrm_notice.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }
    public static function findNotice($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_notice')
            ->select('hrm_notice.*','hrm_employee_info.*','hrm_notice_details.*')
            ->leftJoin('hrm_notice_details', 'hrm_notice_details.notice_id', '=', 'hrm_notice.id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_notice_details.emp_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_notice.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findNoticeDetails($id)
    {
        $query = DB::table('hrm_notice')
            ->select('hrm_notice.*', 'hrm_employee_info.*', 'group.*', 'department.*', 'designation_info.*',  'hrm_notice_details.*')
            ->leftJoin('hrm_notice_details', 'hrm_notice_details.notice_id', '=', 'hrm_notice.id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_notice_details.emp_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->where('hrm_notice.id', $id);
        return $query->get()->first();
    }
    public static function findAllNoticeEmp($id)
    {
        $query = DB::table('hrm_notice')
            ->select('hrm_notice.*', 'hrm_employee_info.*', 'group.*', 'department.*', 'designation_info.*',  'hrm_notice_details.emp_id')
            ->leftJoin('hrm_notice_details', 'hrm_notice_details.notice_id', '=', 'hrm_notice.id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_notice_details.emp_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->where('hrm_notice.id', $id);
        return $query->get();
    }
    public static function findAlldailyReport($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_daily_report_to')
            ->select('hrm_daily_report.*', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name','hrm_daily_report_details.*',
                'hrm_task_questions.question','group.group_name', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('hrm_daily_report', 'hrm_daily_report.id', '=', 'hrm_daily_report_to.dr_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_daily_report.emp_id')
            ->leftJoin('hrm_daily_report_details', 'hrm_daily_report_details.dr_id', '=', 'hrm_daily_report.id')
            ->leftJoin('hrm_task_questions', 'hrm_task_questions.id', '=', 'hrm_daily_report_details.question_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_daily_report.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllCriteria($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_assessment_criteria')
            ->select('hrm_assessment_criteria.*', 'group.group_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_assessment_criteria.group_id')
            ->where('hrm_assessment_criteria.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllEmpDesignation($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*,designation_info.*')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.desi_id', '=', 'designation_info.parent_id')
            ->where('hrm_employee_info.id', $id);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllteams($id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_as_team')
            ->select('hrm_as_team.*', 'hrm_as_team_emp.*', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name')
            ->leftJoin('hrm_as_team_emp', 'hrm_as_team_emp.team_id', '=', 'hrm_as_team.id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_as_team_emp.emp_id')
            ->where('hrm_as_team.id', $id);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllEventsEmp($where, $emp_id, $desi_id, $dep_id, $group_id)
    {
        //dd($desi_id);
        $query = DB::table('hrm_event')
            ->select('hrm_event.id', 'hrm_event.event_name', 'hrm_event.event_date', 'hrm_event.event_timee', 'hrm_event.event_place')
            ->leftJoin('hrm_event_emp', 'hrm_event.id', '=', 'hrm_event_emp.event_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_event_emp.group_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_event_emp.desi_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_event_emp.dep_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_event_emp.emp_id')
            ->where('hrm_event_emp.emp_id', $emp_id)
            ->orWhere(function ($query) use ($desi_id) {
                $query->where('hrm_event_emp.desi_id', $desi_id)
                    ->where('hrm_event_emp.emp_id', 0);
            })
            ->orWhere(function ($query) use ($dep_id) {
                $query->where('hrm_event_emp.dep_id', $dep_id)
                    ->where('hrm_event_emp.desi_id', 0)
                    ->where('hrm_event_emp.emp_id', 0);
            })
            ->orWhere(function ($query) use ($group_id) {
                $query->where('hrm_event_emp.group_id', $group_id)
                    ->where('hrm_event_emp.dep_id', 0)
                    ->where('hrm_event_emp.desi_id', 0)
                    ->where('hrm_event_emp.emp_id', 0);
            })
            ->orderBy('hrm_event.event_date', 'ASC');


        if (!empty($where)) $query->where($where);


        return $query->get();

    }


    public static function findAllEmpByDep($dep_id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.dep_id', $dep_id);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findEmployeebyDesi($emp_id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'department.dep_name', 'designation_info.desi_name')
            ->leftJoin('designation_info', 'designation_info.parent_id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_employee_info.id', $emp_id);
//            ->where('hrm_employee_info.status',1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllEventEmp($event_id, $where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_event_emp')
            ->select('hrm_event_emp.*', 'department.dep_name', 'designation_info.desi_name', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name','group.group_name', 'hrm_event.*')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_event_emp.desi_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_event_emp.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_event_emp.dep_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_event_emp.emp_id')
            ->leftJoin('hrm_event', 'hrm_event.id', '=', 'hrm_event_emp.event_id')
            ->where('hrm_event_emp.event_id', $event_id);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findExtended($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_as_extended')
            ->select('hrm_as_extended.*', 'department.*', 'designation_info.*', 'hrm_employee_info.*', 'group.*')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_as_extended.emp_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->where('hrm_as_extended.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }

    public static function findAllFilterExtended($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_as_extended')
            ->select('hrm_as_extended.*', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name', 'department.dep_name')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_as_extended.emp_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_as_extended.dep_id');
        /*    ->where('hrm_as_extended.status',1);*/
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAssessmentByEmployee($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_emp_assessment')
            ->select('hrm_emp_assessment.*', 'hrm_employee_info.emp_name')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_emp_assessment.ass_from')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_emp_assessment.ass_to')
            ->where('hrm_emp_assessment.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findChildDesi($desi_id)
    {
        $query = DB::table('designation_info as di')
            ->select('dei.id', 'dei.desi_name', 'di.desi_name  as pname', 'di.id  as pid')
            ->leftJoin('designation_info as dei', 'dei.parent_id', '=', 'di.id')
            ->whereNotNull('dei.id');
        return $query->get();
    }

    public static function findChildPerm()
    {
        $query = DB::table('permissions')
            ->select('permissions.*')
            ->whereNotIn('parent_id', array(0))->get();
        return $query;
    }
//    public static function findRolePerm()
//    {
//        $query = DB::table('permissions')
//            ->select('permissions.*')
//            ->whereNotIn('parent_id', array(0))->get();
//        return $query;
//    }

    public static function findEmployeeByDesiId($desi_id)
    {
        $query = DB::table('hrm_employee_info')
            ->select('hrm_employee_info.*', 'group.group_name', 'department.dep_name', 'designation_info.desi_name', 'branch.branch_name')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->leftJoin('branch', 'branch.id', '=', 'hrm_employee_info.branch_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->whereIn('hrm_employee_info.desi_id', $desi_id);
        return $query->get();
    }









    public static function findSSegment($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_salary_segment')
            ->select('ac_salary_segment.*','ac_salary_segment_details.head','department.dep_name', 'designation_info.desi_name', 'group.group_name','department.dep_name')
            ->leftJoin('ac_salary_segment_details', 'ac_salary_segment_details.ss_id', '=', 'ac_salary_segment_details.id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'ac_salary_segment.desi_id')
            ->leftJoin('group', 'group.id', '=', 'ac_salary_segment.group_id')
            ->leftJoin('department', 'department.id', '=', 'ac_salary_segment.dep_id');
        // ->where('ac_salary_segment_details.id', $sid);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }
    public static function findSalarySegment($id,$where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_salary_segment_details')
            ->select('ac_salary_segment.status', 'ac_salary_segment_details.*','department.dep_name','department.id AS dep_id', 'designation_info.desi_name','designation_info.id AS desi_id', 'group.group_name','group.id AS group_id','ac_head.head_name')
            ->leftJoin('ac_salary_segment', 'ac_salary_segment.id', '=', 'ac_salary_segment_details.ss_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'ac_salary_segment.desi_id')
            ->leftJoin('group', 'group.id', '=', 'ac_salary_segment.group_id')
            ->leftJoin('department', 'department.id', '=', 'ac_salary_segment.dep_id')
            ->leftJoin('ac_head', 'ac_head.id', '=', 'ac_salary_segment_details.head')
            ->where('ac_salary_segment_details.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }

    public static function findEmpExpendi($id,$where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_emp_expenditure_set_details')
            ->select('ac_emp_expenditure_set.status', 'ac_emp_expenditure_set_details.*','department.dep_name','department.id AS dep_id', 'designation_info.desi_name','designation_info.id AS desi_id', 'group.group_name','group.id AS group_id','ac_head.head_name')
            ->leftJoin('ac_emp_expenditure_set', 'ac_emp_expenditure_set.id', '=', 'ac_emp_expenditure_set_details.ex_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'ac_emp_expenditure_set.desi_id')
            ->leftJoin('group', 'group.id', '=', 'ac_emp_expenditure_set.group_id')
            ->leftJoin('department', 'department.id', '=', 'ac_emp_expenditure_set.dep_id')
            ->leftJoin('ac_head', 'ac_head.id', '=', 'ac_emp_expenditure_set_details.head')
            ->where('ac_emp_expenditure_set_details.id', $id);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }

    public static function findAllSalarySegment($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_salary_segment_details')
            ->select('ac_salary_segment.*', 'ac_salary_segment_details.*','department.dep_name', 'designation_info.desi_name', 'group.group_name','ac_head.head_name')
            ->leftJoin('ac_salary_segment', 'ac_salary_segment.id', '=', 'ac_salary_segment_details.ss_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'ac_salary_segment.desi_id')
            ->leftJoin('group', 'group.id', '=', 'ac_salary_segment.group_id')
            ->leftJoin('department', 'department.id', '=', 'ac_salary_segment.dep_id')
            ->leftJoin('ac_head', 'ac_head.id', '=', 'ac_salary_segment_details.head');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllEmpExpenditure($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_emp_expenditure_set_details')
            ->select('ac_emp_expenditure_set.*', 'ac_emp_expenditure_set_details.*','department.dep_name', 'designation_info.desi_name', 'group.group_name','ac_head.head_name','department.id AS dep_id','designation_info.id AS desi_id','group.id AS group_id',)
            ->leftJoin('ac_emp_expenditure_set', 'ac_emp_expenditure_set.id', '=', 'ac_emp_expenditure_set_details.ex_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'ac_emp_expenditure_set.desi_id')
            ->leftJoin('group', 'group.id', '=', 'ac_emp_expenditure_set.group_id')
            ->leftJoin('department', 'department.id', '=', 'ac_emp_expenditure_set.dep_id')
            ->leftJoin('ac_head', 'ac_head.id', '=', 'ac_emp_expenditure_set_details.head');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAlldailySalary($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('hrm_is_attemdamce')
            ->select('hrm_is_attemdamce.*', 'department.dep_name', 'designation_info.desi_name', 'hrm_employee_info.emp_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name', 'group.group_name', 'hrm_employee_info.middle_name', 'hrm_employee_info.last_name')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'hrm_is_attemdamce.emp_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->where('hrm_is_attemdamce.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllMonthlySalary($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_monthly_salary_generate')
            ->select('ac_monthly_salary_generate.*', 'department.dep_name', 'designation_info.desi_name', 'hrm_employee_info.emp_name','hrm_employee_info.middle_name', 'hrm_employee_info.last_name', 'group.group_name')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'ac_monthly_salary_generate.emp_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->where('ac_monthly_salary_generate.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->limit(500)->get();
    }


    public static function findPayslip($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_monthly_salary_generate')
            ->select('ac_monthly_salary_generate.*', 'department.dep_name', 'designation_info.desi_name', 'hrm_employee_info.emp_name', 'group.group_name','hrm_employee_info.middle_name','hrm_employee_info.last_name','hrm_employee_info.emp_code','hrm_employee_info.bank_id','hrm_employee_info.bank_account_no','hrm_employee_info.mobile_no','hrm_employee_info.pressent_address','group.office_address','hrm_employee_info.salary_in_bank')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'ac_monthly_salary_generate.emp_id')
            ->leftJoin('designation_info', 'designation_info.id', '=', 'hrm_employee_info.desi_id')
            ->leftJoin('group', 'group.id', '=', 'hrm_employee_info.group_id')
            ->leftJoin('department', 'department.id', '=', 'hrm_employee_info.dep_id')
            ->where('ac_monthly_salary_generate.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }
    public static function findAllIncome($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_head')
            ->select('ac_head.*','ac_salary_segment_details.*')
            ->leftJoin('ac_salary_segment_details', 'ac_salary_segment_details.head', '=', 'ac_head.id')
            //->leftJoin('ac_head', 'ac_head.id', '=', 'ac_salary_segment_details.head')
            ->where('ac_head.status', 1)
            ->where('ac_head.head_type', 0);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }
    public static function findAllExpenditure($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_head')
            ->select('ac_head.*','ac_emp_expenditure_set_details.*')
            ->leftJoin('ac_emp_expenditure_set_details', 'ac_emp_expenditure_set_details.head', '=', 'ac_head.id')
            // ->leftJoin('ac_head', 'ac_head.id', '=', 'ac_emp_expenditure_set_details.head')
            ->where('ac_head.status', 1)
            ->where('ac_head.head_type', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findEmployeeWiseMonthlySalary($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_monthly_salary_generate')
            ->select('ac_monthly_salary_generate.*','hrm_employee_info.emp_name','hrm_employee_info.middle_name','hrm_employee_info.last_name','hrm_employee_info.emp_code')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'ac_monthly_salary_generate.emp_id')
            ->where('ac_monthly_salary_generate.status', 1);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->first();
    }

    public static function findAllItems($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_items')
            ->select('st_items.*','st_unit.unit_name','st_category.category_name')
            ->leftJoin('st_unit', 'st_unit.id', '=', 'st_items.unit_id')
            ->leftJoin('st_category', 'st_category.id', '=', 'st_items.category_id')
            ->where('st_items.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllProduction($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_production')
            ->select('st_production.*','st_section.section_name')
            ->leftJoin('st_section', 'st_section.id', '=', 'st_production.section_id')
            ->where('st_production.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllSections($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_section')
            ->select('st_section.*','group.group_name')
            ->leftJoin('group', 'group.id', '=', 'st_section.group_id')
            ->where('st_section.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findProduction($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_production')
            ->select('st_production.*','st_section.section_name')
            ->leftJoin('st_section', 'st_section.id', '=', 'st_production.section_id')
            ->where('st_production.status', 1);
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllUnitConverter($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_convert_unit')
            ->select('st_convert_unit.*','st_unit.unit_name', 'st_converted_unit.unit_name as converted_unit_name')
            ->leftJoin('st_unit', 'st_convert_unit.unit_id', '=','st_unit.id')
            ->leftJoin('st_unit as st_converted_unit', 'st_convert_unit.converted_unit_id', '=','st_converted_unit.id')
            ->where('st_convert_unit.status', 1)
            ->orderBy('st_convert_unit.id','desc');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }
    public static function findAllUnitSize($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_size')
            ->select('st_size.*','st_unit.unit_name')
            ->leftJoin('st_unit', 'st_size.unit_id', '=','st_unit.id')
            ->where('st_size.status', 1)
            ->orderBy('st_size.id','desc');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }
    public static function findAllCategory($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_category')
            ->select('st_category.*','st_parent_cat.category_name as parent_cat_name')
            ->leftJoin('st_category as st_parent_cat', 'st_category.parent_id', '=','st_parent_cat.id')
            ->where('st_category.status', 1)
            ->orderBy('st_category.id','desc');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllSalaryIncrement($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('ac_salary_increment')
            ->select('ac_salary_increment.*', 'hrm_employee_info.group_id')
            ->leftJoin('hrm_employee_info', 'hrm_employee_info.id', '=', 'ac_salary_increment.emp_id');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllCostEstimate($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_cost_estimation')
            ->select('st_cost_estimation.*',  'st_customer_supplier.name',  'st_condition_last.last_no','st_customer_supplier.id as supplier_id')
            ->leftJoin('st_customer_supplier', 'st_customer_supplier.id', '=', 'st_cost_estimation.customer_id')
            ->leftJoin('st_condition_last', 'st_condition_last.id', '=', 'st_cost_estimation.condition_last_no');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllSectionWiseItems($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_production')
            ->select('st_production.*', 'st_items.item_name', 'st_items.id as item_id')
            ->leftJoin('st_items', 'st_items.id', '=', 'st_production.product_id');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findAllSectionWiseItemList($where = [],$itemIds=[])
    {
        $query = DB::table('st_production')
            ->select('st_production.*', 'st_items.item_name', 'st_items.id as item_id')
            ->leftJoin('st_items', 'st_items.id', '=', 'st_production.product_id')
            ->whereNotIn('st_production.product_id',$itemIds);

         if (!empty($where)) $query->where($where);
        return $query->get();
    }

    public static function findAllSetSectionItem($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_cost_section')
            ->select('st_cost_section.*', 'st_section.section_name', 'st_items.item_name')
            ->leftJoin('st_section', 'st_section.id', '=', 'st_cost_section.section_id')
            ->leftJoin('st_items', 'st_items.id', '=', 'st_cost_section.item_id');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }


    public static function findAllSetCharge($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('st_cost_charge')
            ->select('st_cost_charge.*', 'st_charge.charge_name')
            ->leftJoin('st_charge', 'st_charge.id', '=', 'st_cost_charge.charge_id');

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }
    public static function findAllAttendanceDevice($where = [], $orderBy = [], $groupBy = [])
    {
        $query = DB::table('zkteco_devices')
            ->select('zkteco_devices.*','group.group_name', 'branch.branch_name')
            ->leftJoin('group', 'zkteco_devices.group_id', '=','group.id')
            ->leftJoin('branch', 'zkteco_devices.branch_id', '=','branch.id')
            ->where('zkteco_devices.status', 1)
            ->orderBy('zkteco_devices.id','desc');
        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();
    }

    public static function findEmpWiseIp($where = [],$orderBy=[])
    {
        $query = DB::table('hrm_employee_info')
            ->select('zkteco_devices.ip','hrm_employee_info.id','hrm_emp_device.emp_att_no','hrm_emp_device.device_id','hrm_employee_info.emp_att_no as att_no','zkteco_devices.group_id','zkteco_devices.branch_id','zkteco_devices.id as deviceid')
            ->leftJoin('hrm_emp_device', 'hrm_emp_device.emp_id', '=','hrm_employee_info.id')
            ->leftJoin('zkteco_devices', 'zkteco_devices.id', '=','hrm_emp_device.device_id')
            ->where('zkteco_devices.status',1)
            ->orWhere('zkteco_devices.status',null)
             ->where('hrm_emp_device.status',1)
            ->orWhere('hrm_emp_device.status',null);

        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findOrdrWiseCostingItems($where = [],$orderBy=[],$groupBy=[],$cost_estimation_id)
    {
        $query = DB::table('st_cost_section')
            ->select('st_items.id',
                'st_items.item_name',
                'st_items.product_code',
                'st_items.unit_price',
                'st_unit.short_name',
                'st_cost_section.cost_estimate_id',
                'st_category.is_upper_leather',
                'st_client_order_details.upper_leather_id',
                'st_client_order_details.st_client_order_id',
                'st_client_order_details.article_no',
                'st_cost_section.csmp',
                'st_cost_section.section_id',
                'st_section.section_name',
                'st_store.product_qty as total_stock')
            ->leftjoin('st_items','st_cost_section.item_id','=','st_items.id')
            ->leftjoin('st_unit','st_unit.id','=','st_items.unit_id')
            ->leftjoin('st_category','st_items.category_id','=','st_category.id')
            ->leftjoin('st_store','st_items.id','=','st_store.product_id')
            ->leftjoin('st_client_order_details','st_cost_section.cost_estimate_id','=','st_client_order_details.cost_estimate_id')
            ->leftjoin('st_section','st_cost_section.section_id','=','st_section.id')
            ->whereIn('st_cost_section.cost_estimate_id',$cost_estimation_id);




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findOrdrWiseUpperItems($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_client_order_details')
            ->select('st_items.id',
                'st_items.item_name',
                'st_items.product_code',
                'st_items.unit_price',
                'st_unit.short_name',
                'st_client_order_details.cost_estimate_id',
                'st_category.is_upper_leather',
                'st_client_order_details.upper_leather_id',
                'st_client_order_details.st_client_order_id',
                'st_client_order_details.article_no',
                DB::raw("(SELECT st_cost_section.csmp FROM st_cost_section WHERE st_cost_section.cost_estimate_id = st_client_order_details.cost_estimate_id and st_category.is_upper_leather = 1 limit 1) as csmp"),
                DB::raw("(SELECT st_cost_section.section_id FROM st_cost_section WHERE st_cost_section.cost_estimate_id = st_client_order_details.cost_estimate_id and st_category.is_upper_leather = 1 limit 1) as section_id"),
                'st_section.section_name',
                'st_store.product_qty as total_stock')
            ->leftjoin('st_items','st_client_order_details.upper_leather_id','=','st_items.id')
            ->leftjoin('st_unit','st_unit.id','=','st_items.unit_id')
            ->leftjoin('st_category','st_items.category_id','=','st_category.id')
            ->leftjoin('st_cost_section','st_cost_section.cost_estimate_id','=','st_client_order_details.cost_estimate_id')
            ->leftjoin('st_section','st_cost_section.section_id','=','st_section.id')
            ->leftjoin('st_store','st_items.id','=','st_store.product_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findCostingWiseItems($where = [],$orderBy=[],$groupBy=[],$cost_estimation_id)
    {
        $query = DB::table('st_cost_section')
            ->select('st_items.id',
                'st_cost_section.cost_estimate_id',
                'st_client_order_details.upper_leather_id')
            ->leftjoin('st_items','st_cost_section.item_id','=','st_items.id')
            ->leftjoin('st_category','st_items.category_id','=','st_category.id')
            ->leftjoin('st_client_order_details','st_cost_section.cost_estimate_id','=','st_client_order_details.cost_estimate_id')
            ->whereIn('st_cost_section.cost_estimate_id',$cost_estimation_id);




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findCostingWiseUpperItem($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_client_order_details')
            ->select('st_items.id',
                'st_client_order_details.cost_estimate_id',
                'st_client_order_details.upper_leather_id')
            ->leftjoin('st_items','st_client_order_details.upper_leather_id','=','st_items.id')
            ->leftjoin('st_category','st_items.category_id','=','st_category.id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findPreviousProductionRequeston($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion_details')
            ->select(DB::raw('sum(st_production_requestion_details.product_qty) as total_qty'),
                'st_production_requestion_details.product_id',
                'st_production_requestion.section_id',
                'st_production_requestion.article_no',
                'st_production_requestion.order_no')
            ->leftjoin('st_production_requestion','st_production_requestion.id','=','st_production_requestion_details.requestion_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }


    public static function findPreviousProductionReceive($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_store_requestion_receive_details')
            ->select(DB::raw('sum(st_store_requestion_receive_details.product_qty) as total_qty'),
                'st_store_requestion_receive_details.product_id',
                'st_store_requestion_receive.section_id',
                'st_store_requestion_receive.article_no',
                'st_store_requestion_receive.order_no')
            ->leftjoin('st_store_requestion_receive','st_store_requestion_receive.id','=','st_store_requestion_receive_details.requestion_receive_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findProductionBufferQty($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion_approved_details')
            ->select(DB::raw('sum(st_production_requestion_approved_details.product_qty) as total_qty'),
                'st_production_requestion_approved_details.product_id',
                'st_production_requestion_approved.section_id',
                'st_production_requestion_approved.article_no',
                'st_production_requestion_approved.order_no')
            ->leftjoin('st_production_requestion_approved','st_production_requestion_approved.id','=','st_production_requestion_approved_details.approved_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findAllProductonRequestion($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion')
            ->select('st_production_requestion.serial_no',
                'st_production_requestion.order_no as order_id',
               'st_production_requestion.requestion_date',
               'st_production_requestion.approval_status',
               'st_production_requestion.requestion_by',
               'hrm_employee_info.emp_name',
               'hrm_employee_info.middle_name',
               'hrm_employee_info.last_name',
               'st_client_order.id',
               'st_client_order.order_no')
            ->leftjoin('st_client_order','st_client_order.id','=','st_production_requestion.order_no')
            ->leftjoin('hrm_employee_info','hrm_employee_info.id','=','st_production_requestion.requestion_by');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findPreviousProductionRequestons($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion_details')
            ->select('st_production_requestion_details.product_id',
                'st_production_requestion_details.product_qty',
                'st_production_requestion_details.id',
                'st_production_requestion.section_id',
                'st_production_requestion.serial_no',
                'st_production_requestion.requestion_date',
                'st_production_requestion.article_no',
                'st_production_requestion.order_no')
            ->leftjoin('st_production_requestion','st_production_requestion.id','=','st_production_requestion_details.requestion_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findAllProductonApproved($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion_approved')
            ->select('st_production_requestion_approved.serial_no',
                'st_production_requestion_approved.order_no as order_id',
               'st_production_requestion_approved.approved_date',
               'st_production_requestion_approved.receive_status',
               'st_production_requestion_approved.approved_by',
               'hrm_employee_info.emp_name',
               'hrm_employee_info.middle_name',
               'hrm_employee_info.last_name',
               'st_client_order.id',
               'st_client_order.order_no')
            ->leftjoin('st_client_order','st_client_order.id','=','st_production_requestion_approved.order_no')
            ->leftjoin('hrm_employee_info','hrm_employee_info.id','=','st_production_requestion_approved.approved_by');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findPreviousProductionRequestonApproved($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_production_requestion_approved_details')
            ->select('st_production_requestion_approved_details.product_id',
                'st_production_requestion_approved_details.product_qty',
                'st_production_requestion_approved_details.id',
                'st_production_requestion_approved.section_id',
                'st_production_requestion_approved.serial_no',
                'st_production_requestion_approved.approved_date',
                'st_production_requestion_approved.article_no',
                'st_production_requestion_approved.order_no')
            ->leftjoin('st_production_requestion_approved','st_production_requestion_approved.id','=','st_production_requestion_approved_details.approved_id');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }

    public static function findAllProductonReceive($where = [],$orderBy=[],$groupBy=[])
    {
        $query = DB::table('st_store_requestion_receive')
            ->select('st_store_requestion_receive.serial_no',
                'st_store_requestion_receive.order_no as order_id',
               'st_store_requestion_receive.receive_date',
               'st_store_requestion_receive.status',
               'st_store_requestion_receive.receive_by',
               'hrm_employee_info.emp_name',
               'hrm_employee_info.middle_name',
               'hrm_employee_info.last_name',
               'st_client_order.id',
               'st_client_order.order_no')
            ->leftjoin('st_client_order','st_client_order.id','=','st_store_requestion_receive.order_no')
            ->leftjoin('hrm_employee_info','hrm_employee_info.id','=','st_store_requestion_receive.receive_by');




        if (!empty($where)) $query->where($where);
        foreach ($orderBy as $key => $value) {
            $query->orderBy($key, $value);
        }
        if (!empty($groupBy)) $query->groupBy($groupBy);
        return $query->get();

    }




}
