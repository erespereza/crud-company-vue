<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Departament;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'employees.departament_id', 'departaments.name as departament')
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->paginate(10);
        $departaments = Departament::all();
        return Inertia::render('Employee/Index', ['employees' => $employees, 'departaments' => $departaments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->input());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
    }

    public function EmployeesByDepartament()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departaments.name'))
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->groupBy('departaments.name')->get();
        return Inertia::render('Employee/Graphic', ['data' => $data]);
    }

    public function report()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'employees.departament_id', 'departaments.name as name')
            ->join('departaments', 'departaments.id', '=', 'employees.departament_id')
            ->get();
        $departaments = Departament::all();
        return Inertia::render('Employee/Reports', ['employees' => $employees, 'departaments' => $departaments]);
    }
}
