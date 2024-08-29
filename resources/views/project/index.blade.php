@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Project</title>
@endsection('title')

@section('content')
@if (session('flash_message_update'))
    <div class="alert alert-success">
        {{ session('flash_message_update') }}
    </div>
@elseif (session('flash_message_delete'))
    <div class="alert alert-danger">
        {{ session('flash_message_delete') }}
    </div>
@endif
<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Project</b> -->
        <div class="float-left"><b>Utilities->Project</b></div>
        <div class="float-right"><a class="btn btn-success" href="{{ route('project.create') }}"><i class="fa fa-download"></i>&nbsp;<b>Add New</b></a></div>
    </div>
	<div class="card-body">
		
        <div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Action</th>
                        <th>value</td>
                    </tr>
                </thead>
                <tbody>
                @if($projects)
                    @foreach($projects as $project)
                    <tr>
                        <td>{{$project->name}}</td>
                        <td><a class="btn btn-primary" href="{{ route('project.edit', $project->id) }}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a></td>
                        <td>{{$project->id}}</td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
	</div>
</div>

@endsection('content')

@section('custom-script')
<script>
    new DataTable('#example');

    var element1 = document.getElementById("nav-item-utilities");
    element1.classList.add("active");
    var element2 = document.getElementById("nav-link-utilities");
    element2.classList.remove("collapsed");
    var element3 = document.getElementById("collapseUtilities");
    element3.classList.add("show");
    var element4 = document.getElementById("collapse-item-project");
    element4.classList.add("active");
</script>
@endsection('custom-script')