@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - District</title>
@endsection('title')

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
        <!-- <b>Utilities->District</b> -->
        <div class="float-left"><b>Utilities->District->Create</b></div>
        <div class="float-right">
        <a class="btn btn-primary" href="{{ route('district.index') }}"><i class="fa fa-table"></i> &nbsp;List All Districts</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('district.store') }}" method="post">
                {!! csrf_field() !!}
                <label>Name</label></br>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                @enderror    
                </br>
                <!-- <input type="submit" value="Save" class="btn btn-success"></br> -->
                <!-- fa fa-check-square -->
                <button type="submit" class="btn btn-success" title="Create"><i class="fa fa-check-square"></i> &nbsp; Save</button>
            </form>
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
    var element4 = document.getElementById("collapse-item-district");
    element4.classList.add("active");
</script>
@endsection('custom-script')