@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Employee</title>
@endsection('title')

@section('content')
@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@elseif (session('flash_message_designation_update'))
    <div class="alert alert-success">
        {{ session('flash_message_designation_update') }}
    </div>
@elseif (session('flash_message_designation_delete'))
    <div class="alert alert-success">
        {{ session('flash_message_designation_delete') }}
    </div>
@elseif (session('flash_message_district_update'))
    <div class="alert alert-success">
        {{ session('flash_message_district_update') }}
    </div>
@elseif (session('flash_message_district_delete'))
    <div class="alert alert-success">
        {{ session('flash_message_district_delete') }}
    </div>
@elseif (session('flash_message_office_update'))
    <div class="alert alert-success">
        {{ session('flash_message_office_update') }}
    </div>
@elseif (session('flash_message_office_delete'))
    <div class="alert alert-success">
        {{ session('flash_message_office_delete') }}
    </div>
@elseif (session('flash_message_ctp_update'))
    <div class="alert alert-success">
        {{ session('flash_message_ctp_update') }}
    </div>
@elseif (session('flash_message_ctp_delete'))
    <div class="alert alert-danger">
        {{ session('flash_message_ctp_delete') }}
    </div>
@elseif (session('flash_message_leave_update'))
    <div class="alert alert-warning">
        {{ session('flash_message_leave_update') }}
    </div>
@elseif (session('flash_message_leave_delete'))
    <div class="alert alert-danger">
        {{ session('flash_message_leave_delete') }}
    </div>
@elseif (session('flash_message_resignation_create'))
    <div class="alert alert-danger">
        {{ session('flash_message_resignation_create') }}
    </div>
@endif
<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <!-- <b>Utilities->Employee</b> -->
        <div class="float-left">Utilities->Employee->Update</div>
        <div class="float-right">
        <a class="btn btn-primary" href="{{ route('employee.index') }}"><i class="fa fa-table"></i> &nbsp;List All Employees</a>
        </div>
    </div>
	<div class="card-body">
        <div>
            <form action="{{ route('employee.update', $employee->id) }}" method="post" enctype="multipart/form-data"> 
                {!! csrf_field() !!}
                @method("PATCH")
                <p><b>Basic Details</b></p>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Name</label></br>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $employee->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Address</label></br>
                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $employee->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Phone Number</label></br>
                        <input type="text" name="phno" id="phno" class="form-control @error('phno') is-invalid @enderror" value="{{ old('phno', $employee->phno) }}">
                        @error('phno')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email Id</label></br>
                        <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Level</label></br>
                        <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                <option value="Government" @selected(old('level', $employee->level) == 'Government')>Government</option>
                                <option value="Senior Level Consultant" @selected(old('level', $employee->level) == 'Senior Level Consultant')>Senior Level Consultant</option>
                                <option value="Mid Level Consultant" @selected(old('level', $employee->level) == 'Mid Level Consultant')>Mid Level Consultant</option>
                                <option value="Grade III" @selected(old('level', $employee->level) == 'Grade III')>Grade III</option>
                                <option value="Grade IV" @selected(old('level', $employee->level) == 'Grade IV')>Grade IV</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="status" value="{{$employee->status}}">
                    <div class="col-md-4 mb-3">
                        <label>Project</label></br>
                        <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                            @if($projects)
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" @selected(old('project_id', $employee->project_id) == $project->id)>{{ $project->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                <div class="row my-2">
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
                    @if($employee->emp_file)
                    <div class="col-md-6 mb-3">
                        <a class="btn btn-primary btn-sm" href="{{ route('employee.downloadEmpFile', $employee->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                    </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-success btn-sm" title="Create"><i class="fa fa-check-square"></i> &nbsp; Update</button>
            </form>
        </div>
        <div class="my-3">
                <button class="btn btn-danger btn-sm" title="Delete Employee" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> &nbsp; Delete</button>
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
                    <form method="POST" action="{{ route('employee.destroy', $employee->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger" title="Confirm Delete"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card my-3">
            <div class="card-header bg-white">
                @if($employee->designations->isNotEMpty())
                    <div class="float-left"><b>Designation</b></div>
                    <div class="float-right">
                        <a class="btn btn-success btn-sm" href="{{route('employee_designation.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a>
                    </div>
                @else
                <b>Designation</b>
                @endif
            </div>
            <div class="card-body">
                <div>
                    <table id="example1" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Effect Date</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->designations->isNotEMpty())
                                @foreach($employee->designations as $designation)
                                    <tr>
                                        <td>{{$designation->name}}</td>
                                        <td>{{$designation->pivot->desg_effect_date}}</td>
                                        @if($designation->pivot->file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_designation.downloadEmpDesgFile', $designation->pivot->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_designation.edit', $designation->pivot->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_designation.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card my-3">
            <div class="card-header bg-white">
                @if($employee->offices->isNotEMpty())
                    <div class="float-left"><b>Placed At (Office)</b></div>
                    <div class="float-right">
                        <a class="btn btn-success btn-sm" href="{{route('employee_office.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a>
                    </div>
                @else
                    <b>Placed At</b>
                @endif
            </div>
            <div class="card-body">
                <div>
                    <table id="example2" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>Office</th>
                                <th>Effect Date</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->offices->isNotEMpty())
                                @foreach($employee->offices as $office)
                                    <tr>
                                        <td>{{$office->name}}</td>
                                        <td>{{$office->pivot->office_effect_date}}</td>
                                        @if($office->pivot->file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_office.downloadEmpOfficeFile', $office->pivot->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_office.edit', $office->pivot->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_office.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card my-3">
            <div class="card-header bg-white">
                @if($employee->ctps->isNotEMpty())
                    <div class="float-left"><b>Cost To Project - CTP</b></div>
                    <div class="float-right">
                        <a class="btn btn-success btn-sm" href="{{route('employee_ctp.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a>
                    </div>
                @else
                    <b>Cost To Project - CTP</b>
                @endif
            </div>
            <div class="card-body">
                <div>
                    <table id="example4" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>Total CTP (monthly)</th>
                                <th>Base (monthly)</th>
                                <th>Performance Linked Incentive (monthly)</th>
                                <th>Communication Allowance (monthly)</th>
                                <th>Medical Allowance (monthly)</th>
                                <th>Other Allowances (monthly)</th>
                                <th>Effect Date</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->ctps->isNotEMpty())
                                @foreach($employee->ctps as $ctp)
                                    <tr>
                                        <td>{{$ctp->total_ctp}}</td>
                                        <td>{{$ctp->base}}</td>
                                        <td>{{$ctp->pli}}</td>
                                        <td>{{$ctp->ca}}</td>
                                        <td>{{$ctp->ma}}</td>
                                        <td>{{$ctp->other_allowance}}</td>
                                        <td>{{$ctp->ctp_effect_date}}</td>
                                        @if($ctp->file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_ctp.downloadEmpCtpFile', $ctp->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_ctp.edit', $ctp->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_ctp.create', $employee->id)}}"><i class="fa fa-download"></i>&nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card my-3">
            <div class="card-header bg-white">
                @if($employee->districts->isNotEMpty())
                    <div class="float-left"><b>Posted At (District)</b></div>
                    <div class="float-right">
                        <a class="btn btn-success btn-sm" href="{{route('employee_district.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a>
                    </div>
                @else
                    <b>Posted At (District)</b>
                @endif
            </div>
            <div class="card-body">
                <div>
                    <table id="example3" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>District</th>
                                <th>Effect Date</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->districts->isNotEMpty())
                                @foreach($employee->districts as $district)
                                    <tr>
                                        <td>{{$district->name}}</td>
                                        <td>{{$district->pivot->district_effect_date}}</td>
                                        @if($district->pivot->file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_district.downloadEmpDistFile', $district->pivot->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_district.edit', $district->pivot->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_district.create', $employee->id)}}"><i class="fa fa-download"></i>&nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card my-3">
            <div class="card-header bg-white">
                @if($employee->currentYearLeaves->isNotEMpty())
                    <div class="float-left"><b>Leaves Taken (Current Year)</b></div>
                    <div class="float-right">
                        <a class="btn btn-success btn-sm" href="{{route('employee_leave.create', $employee->id)}}"><i class="fa fa-download"></i> &nbsp;Assign New</a>
                    </div>
                @else
                    <b>Leaves Taken (Current Year)</b>
                @endif
            </div>
            <div class="card-body">
                <div>
                    <table id="example5" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Date (From - To)</th>
                                <th>No. of Days</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->currentYearLeaves->isNotEMpty())
                                @foreach($employee->currentYearLeaves as $leavestaken)
                                    <tr>
                                        <td>{{$leavestaken->name}}</td>
                                        <td>{{$leavestaken->pivot->dates}}</td>
                                        <td>{{$leavestaken->pivot->no_of_days}}</td>
                                        @if($leavestaken->pivot->file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_leave.downloadEmpLeaveFile', $leavestaken->pivot->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_leave.edit', $leavestaken->pivot->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_leave.create', $employee->id)}}"><i class="fa fa-download"></i>&nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card my-3">
            <div class="card-header bg-white">
                    <b>Resignation</b>
            </div>
            <div class="card-body">
                <div>
                    <table id="example6" class="table table-striped table-bordered" style="width:100%; font-size:0.90em;">
                        <thead>
                            <tr>
                                <th>Date of Resignation</th>
                                <th>Supporting Doc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employee->resignation)
                                    <tr>
                                        <td>{{$employee->resignation->resignation_effect_date}}</td>
                                        @if($employee->resignation->resignation_file)
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('employee_resignation.downloadEmpResignationFile', $employee->resignation->id) }}"><i class="fa fa-download"></i>&nbsp;Download Supporting Doc</a>
                                        </td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('employee_resignation.edit', $employee->resignation->id)}}"><i class="fa fa-edit"></i>&nbsp;Edit/Delete</a>
                                        </td>
                                    </tr>
                            @else
                                <tr>
                                    <td> No Records Found</td>
                                    <td> No Records Found</td>
                                    <td><a class="btn btn-success btn-sm" href="{{route('employee_resignation.create', $employee->id)}}"><i class="fa fa-download"></i>&nbsp;Assign New</a></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection('content')

@section('custom-script')
<script>
    new DataTable('#example1',{
        order: [[1, 'desc']],"pageLength":5
    });
    new DataTable('#example2',{
        order: [[1, 'desc']],
    });
    new DataTable('#example3',{
        order: [[1, 'desc']],
    });
    new DataTable('#example4',{
        order: [[5, 'desc']],
    });
    new DataTable('#example5',{
        order: [[1, 'desc']],
    });
    new DataTable('#example6',{
        order: [[1, 'desc']],
    });

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