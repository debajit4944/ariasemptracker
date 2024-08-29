<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\User;
use App\Models\District;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function registration()
    {
        return view('registration');
    }

    function validate_registration(Request $request)
    {
        $request->validate([
            'name'         =>   'required',
            'email'        =>   'required|email|unique:users',
            'password'     =>   'required|min:6'
        ]);

        $data = $request->all();

        User::create([
            'name'  =>  $data['name'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration Completed, now you can login');
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            return redirect('dashboard');
        }

        return redirect('login')->with('success', 'Login details are not valid');
    }

    function dashboard()
    {

        if(Auth::check())
        {

            // For Barchart
            $total_districts = District::count();
            $total_projects = Project::count();
            $total_organizations = Office::count();
            $total_employees = Employee::where('status', 'Active')->get()->count();
            $districts = District::withCount('employees')->get();
            $maxYAxes = $districts->max('employees_count');
            $maxXAxes = District::count();
            $ydata = [];
            $xdata = [];
            foreach ($districts as $district) {
                $ydata[] = $district->name; 
                $xdata[] = $district->employees_count;
            }

            // For Piechart
            $total_offices = Office::count();
            $offices = Office::withCount('employees')->get();
            $pieChartLabels = [];
            $pieChartDatas = [];
            foreach ($offices as $office) {
                $pieChartLabels[] = $office->name; 
                $pieChartDatas[] = $office->employees_count;
            }

            // For BarchartOne
            // Get all offices with their employee count
            $officesWithEmployeeCount = Office::withCount('employees')->get();
            // Prepare an array to store the results
            $employeeCountPerType = [];
            // Loop through each office
            foreach ($officesWithEmployeeCount as $office) {
            // Check if the office type already exists in the result array
            if (!isset($employeeCountPerType[$office->type])) {
                $employeeCountPerType[$office->type] = 0;
            }

            // Add the employee count to the corresponding office type
            $employeeCountPerType[$office->type] += $office->employees_count;
            }

            // You can now access the employee count per office type:
            // echo $employeeCountPerType['Main Office']; // Get employee count for "Main Office" type
            // echo $employeeCountPerType['Branch Office']; // Get employee count for "Branch Office" type
            // ...

            // Alternatively, you can return the array of office types and their employee counts:
            // return $employeeCountPerType;
            $ydata1 = array_keys($employeeCountPerType);
            $xdata1 = array_values($employeeCountPerType);
            $maxXAxes1 = count($ydata1)+1;
            $maxYAxes1 = max($xdata1);

            return view('dashboard',compact('total_districts','total_employees','total_projects','total_organizations','ydata','xdata','maxYAxes','maxXAxes','pieChartLabels','pieChartDatas','total_offices','ydata1','xdata1','maxYAxes1','maxXAxes1'));
            
        }

        return redirect('login')->with('success', 'you are not allowed to access');
    }

    function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('login');
    }
}
