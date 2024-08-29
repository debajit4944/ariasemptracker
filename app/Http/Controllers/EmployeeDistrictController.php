<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\District;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class EmployeeDistrictController extends Controller
{
    public function create(Employee $employee)
    {
        $districts = District::all();
        return view('employee_district.create', compact('employee', 'districts'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'district_effect_date'=>'required',
            'district_file'=>'nullable|mimes:pdf',
        ]);

        $employee = Employee::find($request->employee_id);
        $district_id = $request->district_id;
        $district_effect_date = Carbon::parse($request->district_effect_date);//used Carbon to convert into timestamp format cause database atrribute type is set to timestamp
        $input = ['district_effect_date' => $district_effect_date];

        if($request->has('district_file')){
            $file = $request->file('district_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_district/';
            $file->move($path, $filename);
            $input += ['file' => $path.$filename];
        }
        
        $employee->districts()->attach($district_id, $input);
        return redirect()->route('employee.index')->with('flash_message_emp_district_update', 'Employee_District Updated!'); 
    }

    public function edit($employee_district_id)
    {
        $districts = District::all();
        $employee_district_record = DB::table('employees_districts')->where('id', $employee_district_id)->first();
        $employee_district_record->district_effect_date = Carbon::parse($employee_district_record->district_effect_date)->toDateString();
        return view('employee_district.edit', compact(['employee_district_record', 'districts']));
    }

    public function update(Request $request, $employee_district_id)
    {
        $data = Employee::find($request->employees_id)->districts()->where('employees_districts.id','=',$employee_district_id)->first();

        $request->validate([
            'district_file'=>'nullable|mimes:pdf',
        ]);
        
        if($request->has('district_file')){
            $file = $request->file('district_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_district/';
            $file->move($path, $filename);
            if(File::exists($data->pivot->file)){
                File::delete($data->pivot->file);
            }
            
            $data->pivot->file = $path.$filename; //save the updated filename 
        }

        $data->pivot->districts_id = $request->districts_id;
        $data->pivot->district_effect_date = Carbon::parse($request->district_effect_date);//used Carbon to convert into timestamp format$request->designations_id;
        $data->pivot->updated_at = date('Y-m-d H:i:s');//change timezone at config/app.php
        $data->pivot->save();
        return redirect()->route('employee.edit', $request->employees_id)->with('flash_message_district_update', 'District Updated');
    }

    public function destroy($employee_district_id, $employee_id)
    {
        $record = Employee::find($employee_id)->districts()->where('employees_districts.id','=',$employee_district_id)->first();
        if(File::exists($record->pivot->file)){
            File::delete($record->pivot->file);
        }

        $model = Employee::find($employee_id);
        $model->districts()->newPivotQuery()->where('id', $employee_district_id)->delete();
        return redirect()->route('employee.edit', $employee_id)->with('flash_message_district_delete', 'District Deleted');
    }
    public function test()
    {
        //
        // $districts = District::find(17)->employees;
        // return dd($districts);
        $districts = District::withCount('employees')->get();
        $highestEmployeeCount = $districts->max('employees_count');
        $totalDistrict = District::count();
        $ydata = [];
        $xdata = [];
        foreach ($districts as $district) {
            //echo "District Name: " . $district->name . " - Employees: " . $district->employees_count;
            $ydata[] = $district->name; 
            $xdata[] = $district->employees_count;
        }
        return $totalDistrict;
        //return $xdata;
    }
    // download file
    public function downloadEmpDistFile($empDistId){
        $employee_district_record = DB::table('employees_districts')->where('id', $empDistId)->first();
        $path_to_file = public_path($employee_district_record->file);
        return response()->download($path_to_file);  
    }
}
