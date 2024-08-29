<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Designation;
use App\Models\Office;
use App\Models\District;
use App\Models\Ctp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = Employee::where('status', 'Active')->get();
        return view('employee.index', compact('employees'));
    }
    /**
     * Display a listing of the resource.
     */
    public function displayAllEmp()
    {
        //
        $employees = Employee::all();
        return view('employee.index_display_all', compact('employees'));
        // return "Working";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $designations = Designation::all();
        $projects = Project::all();
        $offices = Office::all();
        $districts = District::all();
        return view('employee.create', compact('projects', 'designations', 'offices', 'districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //If user doesnot fill the address field then enter 'N/A' as default
        //tried declaring address column as default('N/A') in migration file but sql throws error because:-
        //The problem was that the store function was passing the empty values as "null" to the description column, and the only place that default() works, is the time that no value is passed to the database
        if(!$request->filled('address')) {
            $request['address'] = 'N/A';
        }

        $request->validate([
            'name'=>'required',
            'phno'=>'required|unique:employees',
            'email'=>'required|email|unique:employees',
            'base' => 'required|numeric',
            'pli' => 'required|numeric',
            'ca' => 'required|numeric',
            'ma' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'emp_file' => 'nullable|mimes:pdf',
        ]);

        // $input = $request->all();
        $input = [
            'name'=> $request->name, 
            'address'=> $request->address, 
            'phno'=> $request->phno, 
            'email'=> $request->email, 
            'status'=> $request->status, 
            'level'=> $request->level, 
            'project_id'=> $request->project_id
        ];
        
        if($request->has('emp_file')){
            $file = $request->file('emp_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_file/';
            $file->move($path, $filename);
            $input += ['emp_file' => $path.$filename];
        }
        $employee = Employee::create($input);
        $designation_id = $request->designation_id;
        $office_id = $request->office_id;
        $district_id = $request->district_id;
        $employee->designations()->attach($designation_id);
        $employee->offices()->attach($office_id);
        $employee->districts()->attach($district_id);
        $ctp_data = [
            'base' => $request->base,
            'pli' => $request->pli, 
            'ca' => $request->ca, 
            'ma' => $request->ma,
            'other_allowance' => $request->other_allowance,
            'total_ctp' => (int)$request->base + (int)$request->pli + (int)$request->ca + (int)$request->ma + (int)$request->other_allowance,
        ];

        $employee->ctps()->create($ctp_data);
        return redirect()->route('employee.create')->with('flash_message', 'Employee Added!');
        // dd ($input);
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $projects = Project::all();
        return view('employee.edit', compact(['employee', 'projects']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
        //If user doesnot fill the address field then enter 'N/A' as default
        //tried declaring address column as default('N/A') in migration file but sql throws error because:-
        //The problem was that the store function was passing the empty values as "null" to the description column, and the only place that default() works, is the time that no value is passed to the database
        if(!$request->filled('address')) {
            $request['address'] = 'N/A';
        }

        $request->validate([
            'name'=>'required',
            'phno'=>'required',
            'email'=>'required|email',
            'emp_file' => 'nullable|mimes:pdf',
        ]);

        $updateemployee = Employee::find($employee->id);
        $input = $request->all();
        if($request->has('emp_file')){
            $file = $request->file('emp_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_file/';
            $file->move($path, $filename);
            $input['emp_file'] = $path.$filename;
            if(File::exists($updateemployee->emp_file)){
                File::delete($updateemployee->emp_file);
            }
        }
        
        // dd($input) ;
        $updateemployee->update($input);
        return redirect()->route('employee.index')->with('flash_message_update', 'Employee Updated!'); 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
        if(File::exists($employee->emp_file)){
            File::delete($employee->emp_file);
        }
        Employee::destroy($employee->id);
        return redirect()->route('employee.index')->with('flash_message_delete', 'Employee Deleted!'); 
    }

    // download file
    public function downloadEmpFile($id){
        // return dd('OK');
        $emp_record = Employee::find($id);
        $path_to_file = public_path($emp_record->emp_file);
        // dd($path_to_file);
        return response()->download($path_to_file);  
    }

    //export spreadsheet
    public function export() 
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
        // return "Working";
    }
}
