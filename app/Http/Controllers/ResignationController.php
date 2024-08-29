<?php

namespace App\Http\Controllers;

use App\Models\Resignation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        //
        return view('employee_resignation.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'resignation_effect_date'=>'required',
            'resignation_file'=>'nullable|mimes:pdf',
        ]);
        $employee = Employee::find($request->employee_id);
        $resignation_effect_date = Carbon::parse($request->resignation_effect_date);
        
        $resignation_data = [
            'resignation_effect_date' => $resignation_effect_date,
        ];

        if($request->has('resignation_file')){
            $file = $request->file('resignation_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_resignation/';
            $file->move($path, $filename);
            $resignation_data += ['resignation_file' => $path.$filename];
        }
        // return $resignation_data;
        $employee->resignation()->create($resignation_data);
        $employee->status = "Resigned";
        $employee->save();
        return redirect()->route('employee.edit', $request->employee_id)->with('flash_message_resignation_create', 'Employee Resignation Create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resignation $resignation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resignation $resignation)
    {
        //
        $resignation->resignation_effect_date = Carbon::parse($resignation->resignation_effect_date)->toDateString();
        return view('employee_resignation.edit', compact('resignation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resignation $resignation)
    {
        //
        $request->validate([
            'resignation_effect_date'=>'required',
            'resignation_file'=>'nullable|mimes:pdf',
        ]);

        $resignation_effect_date = Carbon::parse($request->resignation_effect_date);
        $input = [
            'resignation_effect_date' => $resignation_effect_date,
        ];
        
        if($request->has('resignation_file')){
            $file = $request->file('resignation_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_resignation/';
            if(File::exists($resignation->resignation_file)){
                File::delete($resignation->resignation_file);
            }
            $file->move($path, $filename);
            $input += ['resignation_file' => $path.$filename];
        }

        $resignation->update($input);
        return redirect()->route('employee.edit', $request->employees_id)->with('flash_message_resignation_update', 'Resignation Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resignation $resignation)
    {
        //
        if(File::exists($resignation->resignation_file)){
            File::delete($resignation->resignation_file);
        }
        Resignation::destroy($resignation->id);
        $employee = Employee::find($resignation->employee_id);
        $employee->status = "Active";
        $employee->save();
        return redirect()->route('employee.edit', $employee)->with('flash_message_ctp_delete', 'CTP Deleted');
    }

    public function downloadEmpResignationFile($empResignationId){
        $employee_resignation_record = Resignation::find($empResignationId);
        $path_to_file = public_path($employee_resignation_record->resignation_file);
        return response()->download($path_to_file);  
    }
}
