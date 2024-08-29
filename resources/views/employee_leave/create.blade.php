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
            <div class="float-left"><b>Utilities->Leave->Create</b></div>
            <div class="float-right">
            <a class="btn btn-primary" href="#"><i class="fa fa-table"></i> &nbsp;List All Offices</a>
            </div>
        </div>
        <div class="card-body">
            <div>
                <form action="{{ route('employee_leave.store') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Leave Type</label>
                            <select name="leave_id" id="leave_id" class="form-control select2 @error('leave_id') is-invalid @enderror">
                                @if($leaves)
                                    @foreach($leaves as $leave)
                                    <option value="{{ $leave->id }}" @selected(old('leave_id') == $leave->id)>{{ $leave->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Date:</label></br>
                            <input type="text" id="datefilter1" name="datefilter1" class="form-control @error('datefilter1') is-invalid @enderror" value="{{ old('datefilter1') }}"/>
                            @error('datefilter1')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror    
                            </br>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="halfday">
                                <label class="form-check-label text-primary" for="halfday">
                                    Check this Box for Half-Day
                                </label>
                            </div>
                            <!-- <label>Half Day:</label></br>
                            <input type="checkbox" id="halfday" name="halfday" value="{{ old('halfday', 1) }}" class="@error('datefilter') is-invalid @enderror">
                            @error('halfday')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror    
                            </br> -->
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
                    <button type="submit" class="btn btn-success" title="Create"><i class="fa fa-check-square"></i> &nbsp; Save</button>
                </form>
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

    const checkbox = document.getElementById('halfday');
    const datefilter1 = document.getElementById('datefilter1');
    const datefilter2 = document.createElement('input');

    datefilter2.id = 'datefilter2';
    datefilter2.className = 'form-control @error('datefilter2') is-invalid @enderror';
    datefilter2.name = 'datefilter2';
    datefilter2.type = 'date'; // Assuming you want a date input element

    checkbox.addEventListener('click', () => {
    if (checkbox.checked) {
        datefilter1.parentNode.replaceChild(datefilter2, datefilter1);
    } else {
        datefilter2.parentNode.replaceChild(datefilter1, datefilter2);
    }
    });
</script>
@endsection('custom-script')