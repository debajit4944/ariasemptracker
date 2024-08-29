<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

use Illuminate\Database\UniqueConstraintViolationException;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $designations = Designation::all();
        return view('designation.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('designation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|unique:designations'
        ]);

        $input = $request->all();
        Designation::create($input);
        return redirect()->route('designation.create')->with('flash_message', 'Designation Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
        return view('designation.edit')->with('designation', $designation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
        $request->validate([
            'name'=>'required|unique:designations'
        ]);
        
        $updatedesignation = Designation::find($designation->id);
        $input = $request->all();
        $updatedesignation->update($input);
        return redirect()->route('designation.index')->with('flash_message_update', 'Designation Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        //
        Designation::destroy($designation->id);
        return redirect()->route('designation.index')->with('flash_message_delete', 'Designation Deleted!'); 
    }
}
