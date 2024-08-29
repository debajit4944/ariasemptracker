<?php

namespace App\Http\Controllers;

use App\Models\Ctp;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CtpController extends Controller
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
        return view('employee_ctp.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'base' => 'required|numeric',
            'pli' => 'required|numeric',
            'ca' => 'required|numeric',
            'ma' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'ctp_effect_date'=>'required',
            'ctp_file'=>'nullable|mimes:pdf',
        ]);
        $employee = Employee::find($request->employee_id);
        $ctp_effect_date = Carbon::parse($request->ctp_effect_date);
        
        $ctp_data = [
            'base' => $request->base,
            'pli' => $request->pli, 
            'ca' => $request->ca, 
            'ma' => $request->ma,
            'other_allowance' => $request->other_allowance,
            'total_ctp' => (int)$request->base + (int)$request->pli + (int)$request->ca + (int)$request->ma + (int)$request->other_allowance,
            'ctp_effect_date' => $ctp_effect_date,
        ];

        if($request->has('ctp_file')){
            $file = $request->file('ctp_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_ctp/';
            $file->move($path, $filename);
            $ctp_data += ['file' => $path.$filename];
        }
        $employee->ctps()->create($ctp_data);
        return redirect()->route('employee.index')->with('flash_message_emp_ctp_update', 'Employee CTP Updated!'); 
        // return $ctp_data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Ctp $ctp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ctp $ctp)
    {
        $ctp->ctp_effect_date = Carbon::parse($ctp->ctp_effect_date)->toDateString();
        return view('employee_ctp.edit', compact('ctp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ctp $ctp)
    {
        //
        $request->validate([
            'base' => 'required|numeric',
            'pli' => 'required|numeric',
            'ca' => 'required|numeric',
            'ma' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'ctp_effect_date'=>'required',
            'ctp_file'=>'nullable|mimes:pdf',
        ]);

        $ctp_effect_date = Carbon::parse($request->ctp_effect_date);
        $input = [
            'base' => $request->base,
            'pli' => $request->pli, 
            'ca' => $request->ca, 
            'ma' => $request->ma,
            'other_allowance' => $request->other_allowance,
            'total_ctp' => (int)$request->base + (int)$request->pli + (int)$request->ca + (int)$request->ma + (int)$request->other_allowance,
            'ctp_effect_date' => $ctp_effect_date,
        ];
        
        if($request->has('ctp_file')){
            $file = $request->file('ctp_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/emp_ctp/';
            if(File::exists($ctp->file)){
                File::delete($ctp->file);
            }
            $file->move($path, $filename);
            $input += ['file' => $path.$filename];
        }

        $ctp->update($input);
        return redirect()->route('employee.edit', $request->employees_id)->with('flash_message_ctp_update', 'CTP Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ctp $ctp)
    {
        if(File::exists($ctp->file)){
            File::delete($ctp->file);
        }
        Ctp::destroy($ctp->id);
        $model = Employee::find($ctp->employee_id);
        return redirect()->route('employee.edit', $model)->with('flash_message_ctp_delete', 'CTP Deleted');
    }
    
    // download file
    public function downloadEmpCtpFile($empCtpId){
        $employee_ctp_record = Ctp::find($empCtpId);
        $path_to_file = public_path($employee_ctp_record->file);
        return response()->download($path_to_file);  
    }
}
