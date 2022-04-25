<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return Department::with('institution')->get();

        return Inertia::render('Unit/Index', [
            'units' => Department::query()
                    ->when(request()->search, function($query, $search){
                        $query->where('name', 'like', "%$search%");
                    })
                    ->with('children','institution')
                    ->withCount('children','staff', 'units')
                    ->departments()
                    ->paginate()
                    ->through(fn($unit)=>[
                        'id' => $unit->id,
                        'name' => $unit->name,
                        'divisions' => $unit->children_count ?? 0,
                        'staff' => $unit->all_staff,
                        // 'institution' => $unit->institution->ministry
                        // 'division' => $unit->children->map(fn($division)=>[
                        //     'division_id' => $division->id,
                        //     'name' => $division->name,
                        ])
                    ,
            'filters' => ['search' => request()->search]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($unit)
    {
        $unit = Department::with('staff','institution', 'parent.parent')->withCount('staff')->find($unit);
        // return $unit->all_staff;
        return Inertia::render('Unit/Show', [
            'unit' => [
                'id' => $unit->id,
                'name' => $unit->name,
                'staff' => $unit->all_staff,
                'institution' => [
                    'id' =>  $unit->institution->id,
                    'name' => $unit->institution->ministry
                ],
                'parent' => $unit->parent != null ?[
                    'id' => $unit->parent->id,
                    'name' => $unit->parent->name,
                    'parent' => $unit->parent->parent != null ?[
                        'id' => $unit->parent->parent->id,
                        'name' => $unit->parent->parent->name,
                    ]: null

                ]: null,
                'divisions' => $unit->children->map(fn($division)=> [
                    'id' => $division->id,
                    'name' => $division->name,
                    'staff' => $division->all_staff,
                    // 'staff' => $division->loadCount('staff')->staff_count > 0 ? $division->loadCount('staff')->staff_count : $division->loadCount('children.staff')
                ])
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}