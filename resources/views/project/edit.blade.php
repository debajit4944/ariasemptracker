@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Project</title>
@endsection('title')

@section('content')

<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Project</b> -->
        <div class="float-left"><b>Utilities->Project->Create</b></div>
        <div class="float-right">
            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-table"></i> &nbsp;List All Projects</button> -->
            <a class="btn btn-primary" href="{{ route('project.index') }}"><i class="fa fa-table"></i> &nbsp;List All Projects</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('project.update', $project->id) }}" method="post">
                {!! csrf_field() !!}
                @method("PATCH")
                <label>Name</label></br>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $project->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror
                </br>
                <button type="submit" class="btn btn-primary" title="Update"><i class="fa fa-edit"></i> &nbsp; Update</button>
                
            </form>
        </div>
        <div class="my-3">
                <button class="btn btn-danger" title="Delete Student" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> &nbsp; Delete</button>
        </div>
	</div>
    <!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to Delete the record?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you are ready to delete the record.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('project.destroy', $project->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" title="Confirm Delete"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection('content')

@section('custom-script')
<script>
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