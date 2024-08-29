<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* table.table-outer{
            font-size:1.3rem;
        }
        table.table-outer td{
            min-width:200px;
            padding:5px
        }
        table.table1, table.table1 th, table.table1 td {
            font-size:1rem;
            border: 1px solid black;
            border-collapse: collapse;
            padding:5px 10px;
        } */
        table.table-design-one{
            border-spacing: 0 20px ;
        }
        table.table-design-one td {
            padding:10px 10px;
        }
        td.col-1{
            min-width:100px;
            border:1px solid black;
            font-weight:bold;
        }
        td.col-2{
            min-width:200px;
            border:1px solid black;
        }
        table.table-design-two, table.table-design-two th, table.table-design-two td{
            border:1px solid black;
            border-collapse: collapse;
        }
        table.table-design-two th, table.table-design-two td{
            padding:5px 15px;
            text-align:center;
            min-width:100px;
        }
        
    </style>
</head>
<body>
    <h2 class="text-success">Detail of Employee - {{$employee->name}}</h2>
    <div>
        <p><b>Basic Details</b></p>
        <hr>
        <table class="table-design-one">
            <tr>
                <td class="col-1"><label>Name:</label></td><td class="col-2">{{$employee->name}}</td> 
                <td class="col-1"><label>Address:</label></td><td class="col-2">@if($employee->address){{$employee->address}}@else N/A @endif</td>
            </tr>
            <tr>
                <td class="col-1"><label>Phone Number:</label></td><td class="col-2">@if($employee->phno){{$employee->phno}}@else N/A @endif</td> 
                <td class="col-1"><label>Email:</label></td><td class="col-2">@if($employee->email){{$employee->email}}@else N/A @endif</td>
            </tr>
            <tr>
                <td class="col-1"><label>Status:</label></td><td class="col-2" colspan=3>@if($employee->status){{$employee->status}}@else N/A @endif</td> 
            </tr>
        </table>
        <br>
    </div>

    <table>
        <tr>
            <td>
                <p style="text-align:center;"><b>Designation Details</b></p>
                <hr>
                @if($employee->designations->isNotEMpty())
                @foreach($employee->designations as $designation)
                    <table class="table-design-two">
                        <th>Designation</th>
                        <th>Designation Effect Date</th>
                    <tr>
                        <td>{{$designation->name}}</td>
                        @if($designation->pivot->desg_effect_date)
                            <td>{{$designation->pivot->desg_effect_date}}</td>
                        @else
                            <td>N/A</td>
                        @endif
                    </tr>
                    </table>
                @endforeach
                @else
                    N/A
                @endif
            </td>
            <td style="padding-left:20px;">
                <p style="text-align:center;"><b>Office Details</b></p>
                <hr>
                @if($employee->offices->isNotEMpty())
                @foreach($employee->offices as $office)
                    <table class="table-design-two">
                        <th>Office</th>
                        <th>Office Effect Date</th>
                    <tr>
                        <td>{{$office->name}}</td>
                        @if($office->pivot->office_effect_date)
                            <td>{{$office->pivot->office_effect_date}}</td>
                        @else
                            <td>N/A</td>
                        @endif
                    </tr>
                    </table>
                @endforeach
                @else
                    N/A
                @endif
                
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <p style="text-align:center;"><b>District Details</b></p>
                <hr>
                @if($employee->districts->isNotEMpty())
                @foreach($employee->districts as $district)
                    <table class="table-design-two">
                    <tr>
                        <th>District</th>
                        <th>District Effect Date</th>
                    </tr>
                    <tr>
                        <td>{{$district->name}}</td>
                        @if($district->pivot->district_effect_date)
                            <td>{{$district->pivot->district_effect_date}}</td>
                        @else
                            <td>N/A</td>
                        @endif
                    </tr>
                    </table>
                @endforeach
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <p style="text-align:center;"><b>CTP Details</b></p>
                <hr>
                @if($employee->ctps->isNotEMpty())
                    @foreach($employee->ctps as $ctp)
                        <table>
                            <tr>
                                <td>{{$ctp->total_ctp}}</td>
                                <td>{{$ctp->base}}</td>
                                <td>{{$ctp->pli}}</td>
                                <td>{{$ctp->ca}}</td>
                                <td>{{$ctp->ma}}</td>
                                <td>{{$ctp->ctp_effect_date}}</td>
                            </tr>
                        </table>
                    @endforeach
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    <table>
        <tr>
        <td>
                <p style="text-align:center;"><b>Leave Detail - (2024)</b></p>
                <hr>
                @if($employee->currentYearLeaves->isNotEMpty())
                    @foreach($employee->currentYearLeaves as $leavestaken)
                    <table>
                        <tr>
                            <th>Leave Type</th>
                            <th>Date From - To</th>
                            <th>No Of Days</th>
                        </tr>
                        <tr>
                            <td>{{$leavestaken->name}}</td>
                            <td>{{$leavestaken->pivot->dates}}</td>
                            <td>{{$leavestaken->pivot->no_of_days}}</td>
                        </tr>
                    </table>
                    @endforeach
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>
</body>
</html>