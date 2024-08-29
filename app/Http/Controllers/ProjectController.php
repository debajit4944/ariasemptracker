<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Database\UniqueConstraintViolationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required|unique:projects',
        ]);
        $input = $request->all();
        Project::create($input);
        return redirect()->route('project.create')->with('flash_message', 'Project Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
        // $editproject = Project::find($project);
        return view('project.edit')->with('project', $project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
        $request->validate([
            'name'=>'required|unique:projects'
        ]);
        
        $updateproject = Project::find($project->id);
        $input = $request->all();
        $updateproject->update($input);
        return redirect()->route('project.index')->with('flash_message_update', 'Project Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
        Project::destroy($project->id);
        return redirect()->route('project.index')->with('flash_message_delete', 'Project Deleted!'); 
    }
}
