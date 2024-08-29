@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Employee All</title>
@endsection('title')

@section('content')

<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Project</b> -->
        <div class="float-left">
            <a class="btn btn-primary" href="{{ route('employee.index') }}"><i class="fa fa-sitemap"></i>&nbsp; Show Active Employees</a>
        </div>
        <div class="float-right"><a class="btn btn-success" href="{{ route('employee.create') }}"><i class="fa fa-download"></i>&nbsp;<b>Add New</b></a></div>
    </div>
	<div class="card-body">
		
        <div>
            <table id="example" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Email Id</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th>Project</th>
                        <th>Designation</th>
                        <th>Office (Placed at)</th>
                        <th>District (Posted at)</th>
                        <th>CTP (Monthly)</th>
                        <th>Action</td>
                    </tr>
                </thead>
                <tbody>
                @if($employees)
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->address}}</td>
                        <td>{{$employee->phno}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->status}}</td>
                        <td>{{$employee->level}}</td>
                        <td>{{$employee->project->name}}</td>
                        <td>
                            @if($employee->latestDesignation->isNotEMpty())
                                @foreach($employee->latestDesignation as $designation)
                                    {{$designation->name}}
                                @endforeach
                            @else
                                <a class="btn btn-primary btn-sm" href="{{route('employee_designation.create', $employee->id)}}"><i class="fa fa-edit"></i>&nbsp;Assign</a>
                            @endif
                        </td>
                        <td>
                            @if($employee->latestOffice->isNotEMpty())
                                @foreach($employee->latestOffice as $office)
                                    {{$office->name}}
                                @endforeach
                            @else
                                <a class="btn btn-primary btn-sm" href="{{route('employee_office.create', $employee->id)}}"><i class="fa fa-edit"></i>&nbsp;Assign</a>
                            @endif
                        </td>
                        <td>
                            @if($employee->latestDistrict->isNotEMpty())
                                @foreach($employee->latestDistrict as $district)
                                    {{$district->name}}
                                @endforeach
                            @else
                                <a class="btn btn-primary btn-sm" href="{{route('employee_district.create', $employee->id)}}"><i class="fa fa-edit"></i>&nbsp;Assign</a>
                            @endif
                        </td>
                        <td>
                            @if($employee->latestCtp->isNotEMpty())
                                @foreach($employee->latestCtp as $ctp)
                                    {{$ctp->total_ctp}}
                                @endforeach
                            @else
                                <a class="btn btn-primary btn-sm" href="{{route('employee_ctp.create', $employee->id)}}"><i class="fa fa-edit"></i>&nbsp;Assign</a>
                            @endif
                        </td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('employee.edit', $employee->id) }}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a></td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Data Available</td>
                    </tr>
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