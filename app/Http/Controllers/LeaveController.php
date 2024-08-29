<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $leaves = Leave::all();
        return view('leave.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('leave.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|unique:leaves',
            'max_allowed_yearly'=>'required',
        ]);

        $input = $request->all();
        Leave::create($input);
        return redirect()->route('leave.create')->with('flash_message', 'Leave Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
        return view('leave.edit')->with('leave', $leave);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
        $request->validate([
            'name'=>'required',
            'max_allowed_yearly'=>'required',
        ]);
        
        $updateleave = Leave::find($leave->id);
        $input = $request->all();
        $updateleave->update($input);
        return redirect()->route('leave.index')->with('flash_message_update', 'Leave Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
        Leave::destroy($leave->id);
        return redirect()->route('leave.index')->with('flash_message_delete', 'Leave Deleted!');
    }
}
