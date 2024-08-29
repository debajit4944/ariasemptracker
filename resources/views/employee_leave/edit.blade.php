@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Leave</title>
@endsection('title')

@section('link-href')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection('link-href')

@section('content')
    <div class="card">
        <!-- Page Heading -->
        <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
        <div class="card-header">
            <!-- <b>Utilities->Office</b> -->
            <div class="float-left"><b>Utilities->Leave->Edit</b></div>
            <div class="float-right">
            <a class="btn btn-primary" href="#"><i class="fa fa-table"></i> &nbsp;List All Offices</a>
            </div>
        </div>
        <div class="card-body">
            <div>
                <form action="{{ route('employee_leave.update', $employee_leave_record->id) }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @method("PATCH")
                    <input type="hidden" name="employee_id" id="employee_id" value="{{$employee_leave_record->employees_id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Leave Type</label>
                            <select name="leave_id" id="leave_id" class="form-control select2 @error('leave_id') is-invalid @enderror">
                                @if($leaves)
                                    @foreach($leaves as $leave)
                                    <option value="{{ $leave->id }}" @selected(old('leave_id', $employee_leave_record->leaves_id) == $leave->id)>{{ $leave->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label>Date:</label></br>
                            @if($employee_leave_record->no_of_days == 0.50)
                                <input type="date" name="datefilter2" class="form-control @error('datefilter2') is-invalid @enderror" value="{{ old('datefilter2', $employee_leave_record->dates) }}"/>
                                @error('datefilter2')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            @else   
                                <input type="text" name="datefilter1" class="form-control @error('datefilter1') is-invalid @enderror" value="{{ old('datefilter1', $employee_leave_record->dates) }}"/>
                                @error('datefilter1')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror 
                            @endif   
                            </br>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="leave_file">Upload File <span class="text-success">(pdf only)</span>:</label>
                            <input type="file" id="leave_file" name="leave_file" class="form-control @error('leave_file') is-invalid @enderror">
                            @error('leave_file')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- <input type="submit" value="Save" class="btn btn-success"></br> -->
                    <!-- fa fa-check-square -->
                    <button type="submit" class="btn btn-success" title="Update"><i class="fa fa-check-square"></i> &nbsp; Update</button>
                </form>
            </div>
            <div class="my-3">
                <button class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> &nbsp; Delete</button>
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
                        <form method="POST" action="{{ route('employee_leave.destroy', ['employee_leave_id'=>$employee_leave_record->id,'employee_id'=>$employee_leave_record->employees_id]) }}" accept-charset="UTF-8" style="display:inline">
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">

    var element1 = document.getElementById("nav-item-employee");
    element1.classList.add("active");
    var element2 = document.getElementById("nav-link-employee");
    element2.classList.remove("collapsed");
    var element3 = document.getElementById("collapseEmployee");
    element3.classList.add("show");
    var element4 = document.getElementById("collapse-item-employee-leave");
    element4.classList.add("active");

    $(function() {

    $('input[name="datefilter1"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter1"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="datefilter1"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    });
</script>
@endsection('custom-script')