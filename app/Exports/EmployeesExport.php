<?php

namespace App\Exports;

use App\Models\Employee;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Employee::all();
    // }
    public function view(): View
    {
        return view('employee.employees_list', [
            'employees' => Employee::where('status', 'active')->get()
        ]);
    }
}
