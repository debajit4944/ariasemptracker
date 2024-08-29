<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Ph No</th>
        <th>Status</th>
        <th>Project</th>
        <th>Designation</th>
        <th>Office</th>
        <th>District</th>
        <th>Ctp</th>
    </tr>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>
                @if($employee->email)
                    {{ $employee->email }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if($employee->phno)
                    {{ $employee->phno }}
                @else
                    N/A
                @endif
            </td>
            <td>{{ $employee->status }}</td>
            <td>{{$employee->project->name}}</td>
            <td>
                @if($employee->latestDesignation->isNotEMpty())
                    @foreach($employee->latestDesignation as $designation)
                        {{$designation->name}}
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td>
                @if($employee->latestOffice->isNotEMpty())
                    @foreach($employee->latestOffice as $office)
                        {{$office->name}}
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td>
                @if($employee->latestDistrict->isNotEMpty())
                    @foreach($employee->latestDistrict as $district)
                        {{$district->name}}
                    @endforeach
                @else
                    N/A
                @endif
            </td>
            <td>
                @if($employee->latestCtp->isNotEMpty())
                    @foreach($employee->latestCtp as $ctp)
                        {{$ctp->total_ctp}}
                    @endforeach
                @else
                    N/A
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>