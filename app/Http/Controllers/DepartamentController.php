<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Http\Requests\StoreDepartamentRequest;
use App\Http\Requests\UpdateDepartamentRequest;
use Inertia\Inertia;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departaments = Departament::all();
        return Inertia::render('Departament/Index', ['departaments' => $departaments]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Departament/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartamentRequest $request)
    {
        $departament = Departament::create($request->input());
        //$departament->save();
        return redirect()->route('departament.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departament $departament)
    {
        return Inertia::render('Departament/Edit', ['departament' => $departament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartamentRequest $request, Departament $departament)
    {
        $departament->update($request->all());
        return redirect()->route('departament.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        $departament->delete();
        return redirect()->route('departament.index');
    }
}
