@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Employee_District_Create</title>
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
        <div class="float-left"><b>Assign new District for "{{$employee->name}}"</b>:</div>
        <div class="float-right">
        <a class="btn btn-primary" href=""><i class="fa fa-table"></i> &nbsp;List All Employees</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('employee_district.store') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>District</label>
                        <select name="district_id" id="district_id" class="form-control select2 @error('district_id') is-invalid @enderror">
                            @if($districts)
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" @selected(old('district_id') == $district->id)>{{ $district->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="district_effect_date">Effective Date:</label>
                        <input type="date" id="district_effect_date" name="district_effect_date" class="form-control @error('district_effect_date') is-invalid @enderror">
                        @error('district_effect_date')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="district_file">Upload File <span class="text-success">(pdf only)</span>:</label>
                        <input type="file" id="district_file" name="district_file" class="form-control @error('district_file') is-invalid @enderror">
                        @error('district_file')
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