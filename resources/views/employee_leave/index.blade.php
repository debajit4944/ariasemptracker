@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Leave</title>
@endsection('title')

@section('content')
@if (session('flash_message_emp_leave_create'))
    <div class="alert alert-success">
        {{ session('flash_message_emp_leave_create') }}
    </div>
@endif
<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Project</b> -->
        <div class="float-left"><b>Utilities->Leave->Index</b></div>
    </div>
	<div class="card-body">
        <div>
            <table id="example" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Project</th>
                        <th>Designation</th>
                        <th>Casual Taken</th>
                        <th>Medical Taken</th>
                        <th>Restricted Taken</th>
                        <th>Special Taken</th>
                        <th>Maternity Taken</th>
                        <th>Paternity Taken</th>
                        <th>Action</td>
                    </tr>
                </thead>
                <tbody>
                @if($employees)
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->phno}}</td>
                        <td>{{$employee->status}}</td>
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
                            @if($employee->currentYearCasualLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearCasualLeaves->sum('pivot.no_of_days') > $max_allowed_casual_leave)
                                    <b class="text-danger">{{$employee->currentYearCasualLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_casual_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearCasualLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_casual_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td>
                            @if($employee->currentYearMedicalLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearMedicalLeaves->sum('pivot.no_of_days') > $max_allowed_medical_leave)
                                    <b class="text-danger">{{$employee->currentYearMedicalLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_medical_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearMedicalLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_medical_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td>
                            @if($employee->currentYearRestrictedLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearRestrictedLeaves->sum('pivot.no_of_days') > $max_allowed_restricted_leave)
                                    <b class="text-danger">{{$employee->currentYearRestrictedLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_restricted_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearRestrictedLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_restricted_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td>
                            @if($employee->currentYearSpecialLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearSpecialLeaves->sum('pivot.no_of_days') > $max_allowed_special_leave)
                                    <b class="text-danger">{{$employee->currentYearSpecialLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_special_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearSpecialLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_special_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td>
                            @if($employee->currentYearMaternityLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearMaternityLeaves->sum('pivot.no_of_days') > $max_allowed_maternity_leave)
                                    <b class="text-danger">{{$employee->currentYearMaternityLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_maternity_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearMaternityLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_maternity_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td>
                            @if($employee->currentYearPaternityLeaves->isNotEMpty())
                                <a href="{{route('employee.edit', $employee->id)}}">
                                @if($employee->currentYearPaternityLeaves->sum('pivot.no_of_days') > $max_allowed_paternity_leave)
                                    <b class="text-danger">{{$employee->currentYearPaternityLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_paternity_leave}}
                                @else
                                    <b class="text-success">{{$employee->currentYearPaternityLeaves->sum('pivot.no_of_days')}}</b> / {{$max_allowed_paternity_leave}}
                                @endif
                                </a>
                            @else
                                {{0}}
                            @endif
                        </td>
                        <td><a class="btn btn-warning text-dark btn-sm" href="{{ route('employee_leave.create', $employee->id) }}"><i class="fa fa-edit"></i>&nbsp;Apply Leave</a></td>
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

<script type="text/javascript">
    new DataTable('#example');

    var element1 = document.getElementById("nav-item-employee");
    element1.classList.add("active");
    var element2 = document.getElementById("nav-link-employee");
    element2.classList.remove("collapsed");
    var element3 = document.getElementById("collapseEmployee");
    element3.classList.add("show");
    var element4 = document.getElementById("collapse-item-employee-leave");
    element4.classList.add("active");

</script>
@endsection('custom-script')