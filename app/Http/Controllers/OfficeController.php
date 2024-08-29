<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offices = Office::all();
        return view('office.index', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('office.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:offices'
        ]);

        $input = $request->all();
        Office::create($input);
        return redirect()->route('office.create')->with('flash_message', 'Office Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        //
        return view('office.edit')->with('office', $office);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        //
        $request->validate([
            'name'=>'required|unique:offices'
        ]);
        
        $updateoffice = Office::find($office->id);
        $input = $request->all();
        $updateoffice->update($input);
        return redirect()->route('office.index')->with('flash_message_update', 'Office Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        //
        Office::destroy($office->id);
        return redirect()->route('office.index')->with('flash_message_delete', 'Office Deleted!'); 
    }
}
