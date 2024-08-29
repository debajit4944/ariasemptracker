@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Employee</title>
@endsection('title')

@section('link-href')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection('link-href')

@section('content')
@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@endif
<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Employee</b> -->
        <div class="float-left"><b>Utilities->Employee->Create</b></div>
        <div class="float-right">
        <a class="btn btn-primary" href="{{ route('employee.index') }}"><i class="fa fa-table"></i> &nbsp;List All Employees</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-12">
                        <b>Basic Details:</b>
                        <hr>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Name</label></br>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Address</label></br>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror  
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Phone Number</label></br>
                        <input type="text" name="phno" id="phno" class="form-control @error('phno') is-invalid @enderror" value="{{ old('phno') }}">
                        @error('phno')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email Id</label></br>
                        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Level</label></br>
                        <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                <option value="Government" @selected(old('level') == 'Government')>Government</option>
                                <option value="Senior Level Consultant" @selected(old('level') == 'Senior Level Consultant')>Senior Level Consultant</option>
                                <option value="Mid Level Consultant" @selected(old('level') == 'Mid Level Consultant')>Mid Level Consultant</option>
                                <option value="Grade III" @selected(old('level') == 'Grade III')>Grade III</option>
                                <option value="Grade IV" @selected(old('level') == 'Grade IV')>Grade IV</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="status" value="Active">
                    <div class="col-md-4 mb-3">
                        <label>Project</label></br>
                        <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                            @if($projects)
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Designation</label></br>
                        <select name="designation_id" id="designation_id" class="form-control select2 @error('designation_id') is-invalid @enderror">
                            @if($designations)
                                @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" @selected(old('designation_id') == $designation->id)>{{ $designation->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('designation_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Office</label></br>
                        <select name="office_id" id="office_id" class="form-control select2 @error('office_id') is-invalid @enderror">
                            @if($offices)
                                @foreach($offices as $office)
                                <option value="{{ $office->id }}" @selected(old('office_id') == $office->id)>{{ $office->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('office_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>District Posted At</label></br>
                        <select name="district_id" id="district_id" class="form-control select2 @error('district_id') is-invalid @enderror">
                            @if($districts)
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" @selected(old('district_id') == $district->id)>{{ $district->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('district_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <b>CTP Structure:</b>
                        <hr>
                    </div>
                    <div class="col-md-3 mb-3">
                    <label>Base Remuneration per Month (Rs)</label></br>
                        <input type="text" name="base" id="base" class="form-control @error('base') is-invalid @enderror" value="{{ old('base') }}">
                        @error('base')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Performance Linked Incentive per Month (Rs)</label></br>
                        <input type="text" name="pli" id="pli" class="form-control @error('pli') is-invalid @enderror" value="{{ old('pli') }}">
                            @error('pli')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Communication Allowance per Month (Rs)</label></br>
                        <input type="text" name="ca" id="ca" class="form-control @error('ca') is-invalid @enderror" value="{{ old('ca') }}">
                            @error('ca')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Medical Allowance per Month (Rs)</label></br>
                        <input type="text" name="ma" id="ma" class="form-control @error('ma') is-invalid @enderror" value="{{ old('ma') }}">
                            @error('ma')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Other Allowances per Month (Rs)</label></br>
                        <input type="text" name="other_allowance" id="other_allowance" class="form-control @error('other_allowance') is-invalid @enderror" value="{{ old('other_allowance') }}">
                            @error('other_allowance')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-12">
                        <b>Related Document:</b>
                        <hr>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="emp_file">Upload File <span class="text-success">(pdf only)</span>:</label>
                        <input type="file" id="emp_file" name="emp_file" class="form-control @error('emp_file') is-invalid @enderror">
                        @error('emp_file')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <!-- <input type="submit" value="Save" class="btn btn-success"></br> -->
                <!-- fa fa-check-square -->
                <button type="submit" class="btn btn-success" title="Create"><i class="fa fa-check-square"></i> &nbsp; Save</button>
            </form>
        </div>
	</div>
</div>

@endsection('content')

@section('custom-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
    $('.select2').select2();

    var element1 = document.getElementById("nav-item-employee");
    element1.classList.add("active");
    var element2 = document.getElementById("nav-link-employee");
    element2.classList.remove("collapsed");
    var element3 = document.getElementById("collapseEmployee");
    element3.classList.add("show");
    var element4 = document.getElementById("collapse-item-employee");
    element4.classList.add("active");
</script>
@endsection('custom-script')