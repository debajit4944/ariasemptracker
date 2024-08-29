<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Database\UniqueConstraintViolationException;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $districts = District::all();
        return view('district.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('district.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|unique:districts'
        ]);

        $input = $request->all();
        District::create($input);
        return redirect()->route('district.create')->with('flash_message', 'District Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
        return view('district.edit')->with('district', $district);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        //
        $request->validate([
            'name'=>'required|unique:districts'
        ]);
        
        $updatedistrict = District::find($district->id);
        $input = $request->all();
        $updatedistrict->update($input);
        return redirect()->route('district.index')->with('flash_message_update', 'District Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        //
        District::destroy($district->id);
        return redirect()->route('district.index')->with('flash_message_delete', 'District Deleted!'); 
    }
    
}
