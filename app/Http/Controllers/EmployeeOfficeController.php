<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Office;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EmployeeOfficeController extends Controller
{
    //
    public function create(Employee $employee)
    {
        $offices = Office::all();
        return view('employee_office.create', compact('employee', 'offices'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'office_effect_date'=>'required',
            'office_file'=>'nullable|mimes:pdf',
        ]);

        $employee = Employee::find($request->employee_id);
        $office_id = $request->office_id;
        $office_effect_date = Carbon::parse($request->office_effect_date);//used Carbon to convert into timestamp format cause database atrribute type is set to timestamp
        $input = ['office_effect_date' => $office_effect_date];

        if($request->has('office_file')){
            $file = $request->file('office_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_office/';
            $file->move($path, $filename);
            $input += ['file' => $path.$filename];
        }
        
        $employee->offices()->attach($office_id, $input);
        return redirect()->route('employee.index')->with('flash_message_emp_office_update', 'Employee_Office Updated!'); 
    }

    public function edit($employee_office_id)
    {
        $offices = Office::all();
        $employee_office_record = DB::table('employees_offices')->where('id', $employee_office_id)->first();
        $employee_office_record->office_effect_date = Carbon::parse($employee_office_record->office_effect_date)->toDateString();
        return view('employee_office.edit', compact(['employee_office_record', 'offices']));
    }

    public function update(Request $request, $employee_office_id)
    {
        $data = Employee::find($request->employees_id)->offices()->where('employees_offices.id','=',$employee_office_id)->first();

        $request->validate([
            'office_file'=>'nullable|mimes:pdf',
        ]);
        
        if($request->has('office_file')){
            $file = $request->file('office_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_office/';
            $file->move($path, $filename);
            if(File::exists($data->pivot->file)){
                File::delete($data->pivot->file);
            }
            
            $data->pivot->file = $path.$filename; //save the updated filename 
        }

        $data->pivot->offices_id = $request->offices_id;
        $data->pivot->office_effect_date = Carbon::parse($request->office_effect_date);//used Carbon to convert into timestamp format$request->designations_id;
        $data->pivot->updated_at = date('Y-m-d H:i:s');//change timezone at config/app.php
        $data->pivot->save();
        return redirect()->route('employee.edit', $request->employees_id)->with('flash_message_office_update', 'Office Updated');
    }

    public function destroy($employee_office_id, $employee_id)
    {
        $record = Employee::find($employee_id)->offices()->where('employees_offices.id','=',$employee_office_id)->first();
        if(File::exists($record->pivot->file)){
            File::delete($record->pivot->file);
        }

        $model = Employee::find($employee_id);
        $model->offices()->newPivotQuery()->where('id', $employee_office_id)->delete();
        return redirect()->route('employee.edit', $employee_id)->with('flash_message_office_delete', 'Office Deleted');
    }
    // download file
    public function downloadEmpOfficeFile($empOfficeId){
        $employee_office_record = DB::table('employees_offices')->where('id', $empOfficeId)->first();
        $path_to_file = public_path($employee_office_record->file);
        return response()->download($path_to_file);  
    }
}
