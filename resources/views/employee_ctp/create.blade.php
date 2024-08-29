@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Employee_CTP_Create</title>
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
        <!-- <b>Utilities->Designation</b> -->
        <div class="float-left"><b>Assign new CTP for "{{$employee->name}}"</b>:</div>
        <div class="float-right">
        <a class="btn btn-primary" href=""><i class="fa fa-table"></i> &nbsp;List All Employees</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('employee_ctp.store') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                        <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                        <div class="row">
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
                            <div class="col-md-6 mb-3">
                                <label for="ctp_effect_date">Effective Date:</label>
                                <input type="date" id="ctp_effect_date" name="ctp_effect_date" class="form-control @error('ctp_effect_date') is-invalid @enderror">
                                @error('ctp_effect_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ctp_file">Upload File <span class="text-success">(pdf only)</span>:</label>
                                <input type="file" id="ctp_file" name="ctp_file" class="form-control @error('ctp_file') is-invalid @enderror">
                                @error('ctp_file')
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