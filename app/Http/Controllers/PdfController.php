<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee;

class PdfController extends Controller
{
    //
    public function generateEmployeeDetailPdf(Employee $employee){
        // $bal = 'bal';
        $pdf = Pdf::loadView('employee.employee_detail_pdf', compact('employee'));
        $file_name = $employee->name.time().'.pdf';
        return $pdf->download($file_name);
        // return view('employee.employee_detail_pdf', compact('employee'));
        // return $employee;
    }
}
