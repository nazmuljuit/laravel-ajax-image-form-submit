<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LateSettingsController;
use App\Http\Controllers\WeekendController;
use App\Http\Controllers\AnnualLeaveController;
use App\Http\Controllers\LeaveSettingsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\TaskQuestionsController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NewLeaveController;
use App\Http\Controllers\DatasyncroniselController;
use App\Http\Controllers\MyDailyReportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\MonthlyAssessmentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ExtendedController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DailysalaryController;
use App\Http\Controllers\MonthlysalaryController;
use App\Http\Controllers\SalarySegmentController;
use App\Http\Controllers\EmpExpenditureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {

    /*SETTINGS*/
     Route::group(['middleware' => ['can:menu.settings']], function () {

        Route::group(['middleware' => ['can:add.company']], function () {

            Route::resource('companys', CompanyController::class);
        });

        Route::group(['middleware' => ['can:add.group']], function () {

            Route::resource('groups', GroupController::class);
            Route::post('group/filter',[GroupController::class,'groupFilter'])->name('group.filter');
        });

        Route::group(['middleware' => ['can:add.branch']], function () {

            Route::resource('branches', BranchController::class);
            Route::post('branch/filter',[BranchController::class,'branchFilter'])->name('branch.filter');
        });

        Route::group(['middleware' => ['can:add.department']], function () {

            Route::resource('departments', DepartmentController::class);
            Route::post('department/filter',[DepartmentController::class,'departmentFilter'])->name('department.filter');
        });

        Route::group(['middleware' => ['can:add.designation']], function () {

            Route::resource('designation', DesignationController::class);
            Route::post('designation/filter',[DesignationController::class,'desiFilter'])->name('designation.filter');
        });

        Route::group(['middleware' => ['can:add.shift']], function () {

            Route::resource('shift', ShiftController::class);
            // shift routing
            Route::get('shift/alter/{id}',[ShiftController::class,'alter']);
            Route::patch('shift/altersave/{id}',[ShiftController::class,'altersave']);
            Route::post('shift/filter',[ShiftController::class,'shiftFilter'])->name('shift.filter');
        });

        Route::group(['middleware' => ['can:late.settings']], function () {

            Route::resource('late', LateSettingsController::class);
            Route::post('late/filter',[LateSettingsController::class,'lateFilter'])->name('late.filter');
        });

        Route::group(['middleware' => ['can:weekend.settings']], function () {

            Route::resource('weekend', WeekendController::class);
            Route::post('weekend/filter',[WeekendController::class,'weekendFilter'])->name('weekend.filter');
        });

        Route::group(['middleware' => ['can:public.leave.setting']], function () {

            Route::resource('annual', AnnualLeaveController::class);
            Route::post('annual/filter',[AnnualLeaveController::class,'annualFilter'])->name('annual.filter');
        });

        Route::group(['middleware' => ['can:leave.settings']], function () {

            Route::resource('leave', LeaveSettingsController::class);
            Route::post('leave/filter',[LeaveSettingsController::class,'leaveFilter'])->name('leave.filter');
        });

        Route::group(['middleware' => ['can:add.leave']], function () {

            Route::resource('addleave', NewLeaveController::class);
            Route::post('addleave/filter',[NewLeaveController::class,'addleaveFilter'])->name('addleave.filter');
        });


    });
        /*EVENT && TASK*/
         Route::group(['middleware' => ['can:menu.event.task']], function () {

            Route::group(['middleware' => ['can:add.task.questions']], function () {

                Route::resource('taskques', TaskQuestionsController::class);
                Route::post('taskques/filter',[TaskQuestionsController::class,'taskquesFilter'])->name('taskques.filter');
            });

            Route::group(['middleware' => ['can:my.daily.reports']], function () {

                Route::resource('mydailyreport', MyDailyReportController::class)->except(['index','destroy']);
                Route::get('myreport/view',[MyDailyReportController::class,'viewreport'])->name('dailyreport.view');
            });

            Route::group(['middleware' => ['can:add.event']], function () {

                Route::resource('event', EventController::class);
            });

            Route::group(['middleware' => ['can:event.list']], function () {

                Route::resource('event', EventController::class);
                Route::post('event/filter',[EventController::class,'eventFilter'])->name('event.filter');
            });

            Route::group(['middleware' => ['can:calender']], function () {

                Route::get('calender',[EventController::class,'calenderView'])->name('calender.view');
            });

            Route::group(['middleware' => ['can:daily.report.list']], function () {


                Route::resource('mydailyreport', MyDailyReportController::class)->only(['index','destroy']);
                Route::post('myreport/filter',[MyDailyReportController::class,'dailyReportFilter'])->name('dailyreport.filter');
            });


    });

        /*EMPLOYEE*/
        Route::group(['middleware' => ['can:menu.employee']], function () {

            Route::group(['middleware' => ['can:add.employee']], function () {

                Route::resource('employees', EmployeeController::class)->except(['index']);

                Route::get('emp/bonus/{id}',[EmployeeController::class,'bonusSettings']);
                Route::post('emp/bonus',[EmployeeController::class,'bonusUpdate'])->name('employees.bonus.update');
                Route::get('emp/weekend/{id}',[EmployeeController::class,'weekendSettings']);
                Route::post('emp/weekend',[EmployeeController::class,'weekendUpdate'])->name('employees.weekend.update');
            });

            Route::group(['middleware' => ['can:employee.leave']], function () {

                Route::resource('empleave', EmployeeLeaveController::class);
                Route::post('empleave/filter',[EmployeeLeaveController::class,'empleaveFilter'])->name('empleave.filter');
            });

            Route::group(['middleware' => ['can:employee.list']], function () {

                Route::resource('employees', EmployeeController::class)->only(['index']);
                Route::post('emp/filter',[EmployeeController::class,'empFilter'])->name('emp.filter');
            });


        });


                /*TIME && ATTENDANCE*/
        Route::group(['middleware' => ['can:menu.time.attendance']], function () {

            Route::group(['middleware' => ['can:manual.attendance']], function () {

                Route::resource('manual', ManualController::class);
            });

            Route::group(['middleware' => ['can:attendance.list']], function () {

                Route::resource('attendance', AttendanceController::class);
                Route::post('att/filter',[ManualController::class,'empFilter'])->name('att.filter');
                Route::get('att/time/edit/{id}',[AttendanceController::class,'attTimeEdit']);
                Route::post('att/time/update',[AttendanceController::class,'attTimeUpdate'])->name('att.time.update');
                Route::post('att/update',[AttendanceController::class,'attUpdate'])->name('att.update');
            });


            Route::group(['middleware' => ['can:data.syncronise']], function () {

                //Data Syncornise Routing
                Route::get('data/syncronise',[DatasyncroniselController::class,'fileUpload'])->name('data.syncronise.index');
                Route::post('data/syncronise',[DatasyncroniselController::class,'saveUpload'])->name('file.upload.save');
            });


            Route::group(['middleware' => ['can:daily.attendance.update']], function () {

                 Route::get('dailyattendance',[AttendanceController::class,'dailyattendance'])->name('dailyattendance.index');
                 Route::post('dailyAttendancefilter',[AttendanceController::class,'dailyAttendanceFilter'])->name('daily.attendance.filter');
                 Route::post('daily/attstore',[AttendanceController::class,'dailyattstore'])->name('daily.attstore');
            });

            Route::group(['middleware' => ['can:my.attendance']], function () {

                Route::get('myattendance',[AttendanceController::class,'myattendance'])->name('myattendance.list');

            });
                /*attendance reports*/

            Route::group(['middleware' => ['can:attendance.reports']], function () {

                Route::group(['middleware' => ['can:attendance.monitor']], function () {

                     Route::post('attMonitor/filter',[AttendanceController::class,'attMonFilter'])->name('attMonitor.filter');
            
                     Route::get('atten/monitor',[AttendanceController::class,'attendancemonitor'])->name('atten.monitor');
                     Route::post('monitor/filter',[AttendanceController::class,'attendanceMonitorFilter'])->name('monitor.filter');
                });


            });


        });



        /*ASSESSMENT*/
         Route::group(['middleware' => ['can:menu.employee.assessment']], function () {

            Route::group(['middleware' => ['can:add.criteria']], function () {

                Route::resource('criteria', CriteriaController::class);
            });

            Route::group(['middleware' => ['can:monthly.assessment']], function () {

                Route::resource('monthlyassessment', MonthlyAssessmentController::class);

                Route::get('assessment/{group_id}/{emp_id}',[MonthlyAssessmentController::class,'doassessment']);
                Route::patch('assessment/saveassessment',[MonthlyAssessmentController::class,'saveassessment'])->name('assessment.save');
            });

            Route::group(['middleware' => ['can:add.team']], function () {

                Route::resource('team', TeamController::class);
            });

            Route::group(['middleware' => ['can:add.extended']], function () {

                Route::resource('extended', ExtendedController::class);
                Route::post('extended/filter',[ExtendedController::class,'extFilter'])->name('extended.filter');
            });

            Route::group(['middleware' => ['can:assessment.list']], function () {

                Route::get('assessmentlist',[MonthlyAssessmentController::class,'assessmentList'])->name('assessment.list');
                Route::get('assessmentdetails/{id}',[MonthlyAssessmentController::class,'assessmentdetails']);
            });



         });
        /*PAYROLL*/
         Route::group(['middleware' => ['can:menu.salary.process']], function () {

            Route::group(['middleware' => ['can:add.head']], function () {

                Route::resource('head', HeadController::class);
            });

            Route::group(['middleware' => ['can:add.policy']], function () {

                Route::resource('bonus', BonusController::class);
            });

            Route::group(['middleware' => ['can:daily.salary.generate']], function () {

                Route::resource('dailysalary', DailysalaryController::class);
                Route::post('dailysalary/filter',[DailysalaryController::class,'dailysalaryFilter'])->name('dailysalary.filter');
            });

            Route::group(['middleware' => ['can:monthly.salary.generate']], function () {

                Route::resource('monthlysalary', MonthlysalaryController::class);
                Route::post('monthlysalary/filter',[MonthlysalaryController::class,'monthlySalaryFilter'])->name('monthlysalary.filter');

            });

            Route::group(['middleware' => ['can:add.salary.segment']], function () {

                Route::resource('salarysegment', SalarySegmentController::class);
            });

            Route::group(['middleware' => ['can:add.expenditure']], function () {

                Route::resource('empexpenditure', EmpExpenditureController::class);
            });


            Route::group(['middleware' => ['can:daily.salary.list']], function () {


                Route::get('dailysalarylist',[DailysalaryController::class,'dailysalaryList'])->name('dailysalary.list');
                Route::post('dailysalarylist/filter',[DailysalaryController::class,'dailysalaryFilterList'])->name('dailysalaryfilter.list');
                Route::get('dailysalarylist/view/{id}',[DailysalaryController::class,'dailysalaryFilterListview'])->name('dailysalaryfilter.view');
            });

            Route::group(['middleware' => ['can:monthly.salary.list']], function () {

                Route::get('monthlysalarylist',[MonthlysalaryController::class,'monthlysalaryList'])->name('monthlysalary.list');

                Route::post('monthlysalarylist/filter',[MonthlysalaryController::class,'monthlysalaryFilterList'])->name('monthlysalaryfilter.list');
                Route::get('monthlysalarylist/view/{id}',[MonthlysalaryController::class,'monthlysalaryFilterListview'])->name('monthlysalaryfilter.view');


            });





         });
        /*ADMIN CONFIG*/
        Route::group(['middleware' => ['can:menu.admin.config']], function () {

            Route::group(['middleware' => ['can:roles']], function () {

                Route::get('role',[SuperAdminController::class,'adminRole'])->name('admin.role');
                Route::get('role/create',[SuperAdminController::class,'roleCreate'])->name('role.create');
                Route::post('save/role',[SuperAdminController::class,'saveRole'])->name('role.save');
                Route::get('role/edit/{id}',[SuperAdminController::class,'roleEdit']);
                Route::get('roleAssign/{id}',[SuperAdminController::class,'roleAssign']);
                Route::post('assign/role',[SuperAdminController::class,'assignRole']);
            });


            Route::group(['middleware' => ['can:permissions']], function () {

                Route::get('permission',[SuperAdminController::class,'adminPermission'])->name('admin.permission');
                Route::get('permission/create',[SuperAdminController::class,'permissionCreate'])->name('permission.create');
                Route::post('save/permission',[SuperAdminController::class,'savePermission'])->name('permission.save');
                Route::post('save/childpermission',[SuperAdminController::class,'saveChildPerm'])->name('childpermission.save');
                Route::get('permission/edit/{id}',[SuperAdminController::class,'permEdit']);
                Route::get('childperm/edit/{parent_id}/{id}',[SuperAdminController::class,'childpermEdit']);
                //Route::get('permission/edit/{id}',[SuperAdminController::class,'permissionEdit']);
                Route::get('permission/assign/{id}',[SuperAdminController::class,'permissionAssign']);
                Route::post('assign/permission',[SuperAdminController::class,'assignPermission'])->name('assign.permission');
            });

            Route::group(['middleware' => ['can:user.list']], function () {

                Route::get('admin/list',[SuperAdminController::class,'adminList'])->name('admin.list');
                Route::get('admin/create',[SuperAdminController::class,'adminCreate'])->name('admin.create');
                Route::post('save/admin',[SuperAdminController::class,'saveAdmin'])->name('admin.save');
                Route::get('admin/edit/{id}',[SuperAdminController::class,'adminEdit']);
            });


            Route::group(['middleware' => ['can:log.reports']], function () {

                 Route::get('logreport',[SuperAdminController::class,'adminlogreport'])->name('admin.logreport');
            });





         });
        Route::post('ajax/group',[EmployeeController::class,'ajaxSearchGroup']);
        Route::post('ajax/department',[EmployeeController::class,'ajaxSearchDepartment']);
        Route::post('ajax/designation',[EmployeeController::class,'ajaxSearchEmpDesignation']);
        Route::post('ajax/leave_enable_check',[EmployeeLeaveController::class,'ajaxLeaveEnableCheck']);
        Route::post('ajax/leave_application_check',[EmployeeLeaveController::class,'ajaxLeaveAppliCheck']);
        Route::post('ajax/deventload',[EventController::class,'ajaxEventLoadData']);
    });




