<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EmployeeLeaveController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::where('status', 'Active')->get();
        $leave_types = Leave::all();
        foreach($leave_types as $leave_type){
            if($leave_type->name == "Casual"){
                $max_allowed_casual_leave = $leave_type->max_allowed_yearly;
            }
            elseif($leave_type->name == "Medical"){
                $max_allowed_medical_leave = $leave_type->max_allowed_yearly;
            }
            elseif($leave_type->name == "Restricted"){
                $max_allowed_restricted_leave = $leave_type->max_allowed_yearly;
            }
            elseif($leave_type->name == "Special"){
                $max_allowed_special_leave = $leave_type->max_allowed_yearly;
            }
            elseif($leave_type->name == "Maternity"){
                $max_allowed_maternity_leave = $leave_type->max_allowed_yearly;
            }
            elseif($leave_type->name == "Paternity"){
                $max_allowed_paternity_leave = $leave_type->max_allowed_yearly;
            }
        }
        return view('employee_leave.index', compact('employees','max_allowed_casual_leave', 'max_allowed_medical_leave', 'max_allowed_restricted_leave', 'max_allowed_special_leave', 'max_allowed_maternity_leave', 'max_allowed_paternity_leave'));
        // return $max_allowed_casual_leave;
        // return $leave_types;
    }

    public function create(Employee $employee)
    {
        $leaves = Leave::all();
        return view('employee_leave.create', compact('employee', 'leaves'));
    }

    public function store(Request $request)
    {
        if($request->datefilter2){
            $request->validate([
                'datefilter2'=>'required',
                'leave_file'=>'nullable|mimes:pdf',
            ]);
        }else{
            $request->validate([
                'datefilter1'=>'required',
                'leave_file'=>'nullable|mimes:pdf',
            ]);
        }
       
        if($request->datefilter2){
            $employee = Employee::find($request->employee_id);
            $leave_id = $request->leave_id;
            $parsedStartDate = Carbon::parse($request->datefilter2);
            $no_of_days = 0.5;
            $year = $parsedStartDate->year;
            $date = $request->datefilter2;
        }else{
            $employee = Employee::find($request->employee_id);
            $leave_id = $request->leave_id;
            list($startDateString, $endDateString) = explode(" - ", $request->datefilter1);
            $parsedStartDate = Carbon::parse($startDateString);
            $parsedEndDate = Carbon::parse($endDateString);
            $no_of_days = ($parsedStartDate->diffInDays($parsedEndDate))+1;
            $year = $parsedStartDate->year;
            $date = $request->datefilter1;
        }
        $input = ['no_of_days' => $no_of_days, 'year' => $year, 'dates' => $date, 'approved' => 1];

        if($request->has('leave_file')){
            $file = $request->file('leave_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_leave/';
            $file->move($path, $filename);
            $input += ['file' => $path.$filename];
        }
        
        $employee->leaves()->attach($leave_id, $input);
        return redirect()->route('employee_leave.index')->with('flash_message_emp_leave_create', 'Employee_Leave Created!'); 
    }

    public function edit($employee_leave_id)
    {
        $leaves = Leave::all();
        $employee_leave_record = DB::table('employees_leaves')->where('id', $employee_leave_id)->first();
        // $employee_leave_record->desg_effect_date = Carbon::parse($employee_designation_record->desg_effect_date)->toDateString();
        return view('employee_leave.edit', compact(['employee_leave_record', 'leaves']));
        //return $employee_leave_record;
    }
    public function update(Request $request, $employee_leave_id)
    {
        $request->validate([
            'leave_file'=>'nullable|mimes:pdf',
        ]);

        $data = Employee::find($request->employee_id)->currentYearLeaves()->where('employees_leaves.id','=',$employee_leave_id)->first();
        $leave_id = $request->leave_id;
        if($request->datefilter2){
            $parsedStartDate = Carbon::parse($request->datefilter2);
            $no_of_days = 0.5;
            $year = $parsedStartDate->year;
            $date = $request->datefilter2;
        }else
        {
            list($startDateString, $endDateString) = explode(" - ", $request->datefilter1);
            $parsedStartDate = Carbon::parse($startDateString);
            $parsedEndDate = Carbon::parse($endDateString);
            $no_of_days = ($parsedStartDate->diffInDays($parsedEndDate))+1;
            $year = $parsedStartDate->year;
            $date = $request->datefilter1;
        }
        $data->pivot->leaves_id = $request->leave_id;
        $data->pivot->no_of_days = $no_of_days;
        $data->pivot->year = $year;
        $data->pivot->dates = $date;
        $data->pivot->approved = 1;
        if($request->has('leave_file')){
            $file = $request->file('leave_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_leave/';
            $file->move($path, $filename);
            if(File::exists($data->pivot->file)){
                File::delete($data->pivot->file);
            }
            $data->pivot->file = $path.$filename;
        }
        $data->pivot->updated_at = date('Y-m-d H:i:s');//change timezone at config/app.php
        $data->pivot->save();
        return redirect()->route('employee.edit', $request->employee_id)->with('flash_message_leave_update', 'Leave Updated');
    }

    public function destroy($employee_leave_id, $employee_id)
    {
        $model = Employee::find($employee_id);
        $model->currentYearLeaves()->newPivotQuery()->where('id', $employee_leave_id)->delete();
        return redirect()->route('employee.edit', $employee_id)->with('flash_message_leave_delete', 'Leave Deleted');
    }

    // download file
    public function downloadEmpLeaveFile($empLeaveId){
        $employee_leave_record = DB::table('employees_leaves')->where('id', $empLeaveId)->first();
        $path_to_file = public_path($employee_leave_record->file);
        return response()->download($path_to_file);  
    }
}
