<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function getEmployeeData()
    {
        $userId =session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $data = User::select(
            "hrm_employee_info.id",
            "hrm_employee_info.emp_name",
            "hrm_employee_info.middle_name",
            "hrm_employee_info.last_name",
            "hrm_employee_info.emp_father_name",
            "hrm_employee_info.emp_mother_name",
            "hrm_employee_info.emergency_person",
            "hrm_employee_info.emergency_contact",
            "hrm_employee_info.birth_date",
            "hrm_employee_info.birth_place",
            "hrm_employee_info.emp_blood_group",
            "hrm_employee_info.gender",
            "hrm_employee_info.religion",
            "hrm_employee_info.marital_status",
            "hrm_employee_info.national_id",
            "hrm_employee_info.passport_no",
            "hrm_employee_info.driving_licence",
            "hrm_employee_info.nationality",
            "hrm_employee_info.remarks",
            "hrm_employee_info.mobile_no",
            "hrm_employee_info.pressent_address",
            "hrm_employee_info.permanent_address",
            "hrm_employee_info.permanent_division_id",
            "hrm_employee_info.permanent_district_id",
            "hrm_employee_info.permanent_ps_id",
            "hrm_employee_info.present_division_id",
            "hrm_employee_info.present_district_id",
            "hrm_employee_info.present_ps_id",
            "hrm_employee_info.birth_certificate_no",
            "hrm_employee_info.land_phone",
            "hrm_employee_info.emp_photo"
        )
            ->leftJoin("hrm_employee_info", "users.emp_id", "=", "hrm_employee_info.id")
            ->where(['users.id' => $userId])
            ->first();

        return $data;
    }
}
