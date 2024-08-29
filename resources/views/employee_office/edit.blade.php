@extends('layouts.master')

@section('title')
<title>AriasEmpTracker - Designation</title>
@endsection('title')

@section('link-href')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection('link-href')

@section('content')
<div class="card">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
	<div class="card-header">
        <div class="float-left"><b>Utilities->Office->Create</b></div>
        <div class="float-right">
            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-table"></i> &nbsp;List All Designations</button> -->
            <a class="btn btn-primary" href=" "><i class="fa fa-table"></i> &nbsp;List All Employees</a>
        </div>
    </div>
	<div class="card-body">
        <div>
        <form action="{{ route('employee_office.update', $employee_office_record->id) }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method("PATCH")
                    <input type="hidden" name="employees_id" id="employees_id" value="{{$employee_office_record->employees_id}}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Office</label>
                            <select name="offices_id" id="offices_id" class="form-control select2">
                                @if($offices)
                                    @foreach($offices as $office)
                                        <option value="{{ $office->id }}" @selected(old('offices_id', $employee_office_record->offices_id) == $office->id)>{{ $office->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="office_effect_date">Effective Date:</label>
                            <input type="date" id="office_effect_date" name="office_effect_date" value="{{ old('office_effect_date', $employee_office_record->office_effect_date) }}" class="form-control @error('office_effect_date') is-invalid @enderror">
                            @error('office_effect_date')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="office_file">Upload File <span class="text-success">(pdf only)</span>:</label>
                            <input type="file" id="office_file" name="office_file" class="form-control @error('office_file') is-invalid @enderror">
                            @error('office_file')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                <!-- <input type="submit" value="Save" class="btn btn-success"></br> -->
                <!-- fa fa-check-square -->
                <button type="submit" class="btn btn-success btn-sm" title="Update"><i class="fa fa-check-square"></i> &nbsp; Update</button>
            </form>
        </div>
        <div class="my-3">
                <button class="btn btn-danger btn-sm" title="Delete Student" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> &nbsp; Delete</button>
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
                    <form method="POST" action="{{ route('employee_office.destroy', ['employee_office_id'=>$employee_office_record->id,'employee_id'=>$employee_office_record->employees_id]) }}" accept-charset="UTF-8" style="display:inline">
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