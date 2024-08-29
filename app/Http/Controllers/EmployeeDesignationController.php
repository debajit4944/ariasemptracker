<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Designation;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EmployeeDesignationController extends Controller
{
    public function create(Employee $employee)
    {
        $designations = Designation::all();
        return view('employee_designation.create', compact('employee', 'designations'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'desg_effect_date'=>'required',
            'desg_file'=>'nullable|mimes:pdf',
        ]);

        $employee = Employee::find($request->employee_id);
        $designation_id = $request->designation_id;
        $desg_effect_date = Carbon::parse($request->desg_effect_date);//used Carbon to convert into timestamp format cause database atrribute type is set to timestamp
        $input = ['desg_effect_date' => $desg_effect_date];
        if($request->has('desg_file')){
            $file = $request->file('desg_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_designation/';
            $file->move($path, $filename);
            $input += ['file' => $path.$filename];
        }
        $employee->designations()->attach($designation_id, $input);
        return redirect()->route('employee.index')->with('flash_message_emp_desg_update', 'Employee_Designation Updated!'); 
        // return $filename;
    }

    public function edit($employee_designation_id)
    {
        $designations = Designation::all();
        $employee_designation_record = DB::table('employees_designations')->where('id', $employee_designation_id)->first();
        $employee_designation_record->desg_effect_date = Carbon::parse($employee_designation_record->desg_effect_date)->toDateString();
        return view('employee_designation.edit', compact(['employee_designation_record', 'designations']));
    }

    public function update(Request $request, $employee_designation_id)
    {
        $data = Employee::find($request->employees_id)->designations()->where('employees_designations.id','=',$employee_designation_id)->first();

        $request->validate([
            'desg_file'=>'nullable|mimes:pdf',
        ]);
        
        if($request->has('desg_file')){
            $file = $request->file('desg_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_designation/';
            $file->move($path, $filename);
            if(File::exists($data->pivot->file)){
                File::delete($data->pivot->file);
            }
            
            $data->pivot->file = $path.$filename; //save the updated filename 
        }
        
        $data->pivot->designations_id = $request->designations_id;
        $data->pivot->desg_effect_date = Carbon::parse($request->desg_effect_date);//used Carbon to convert into timestamp format$request->designations_id;
        $data->pivot->updated_at = date('Y-m-d H:i:s');//change timezone at config/app.php
        $data->pivot->save();
        return redirect()->route('employee.edit', $request->employees_id)->with('flash_message_designation_update', 'Designation Updated');
    }

    public function destroy($employee_designation_id, $employee_id)
    {
        $record = Employee::find($employee_id)->designations()->where('employees_designations.id','=',$employee_designation_id)->first();
        if(File::exists($record->pivot->file)){
            File::delete($record->pivot->file);
        }

        $model = Employee::find($employee_id);
        $model->designations()->newPivotQuery()->where('id', $employee_designation_id)->delete();
        return redirect()->route('employee.edit', $employee_id)->with('flash_message_designation_delete', 'Designation Deleted');
    }

    // download file
    public function downloadEmpDesgFile($empDesgId){
        $employee_designation_record = DB::table('employees_designations')->where('id', $empDesgId)->first();
        $path_to_file = public_path($employee_designation_record->file);
        return response()->download($path_to_file);  
    }
}
