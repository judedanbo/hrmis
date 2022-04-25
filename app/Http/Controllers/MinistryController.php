<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMinistryRequest;
use App\Http\Requests\UpdateMinistryRequest;
use App\Models\Ministry;
use Inertia\Inertia;
use Request;

class MinistryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Institution/Index',[
            'institutions' => Ministry::query()
                    ->when(request()->search, function($query, $search){
                        $query->where('ministry','like', "%$search%");
                    })
                    ->with('departments')
                    ->withCount('units', 'departments')
                    ->paginate()
                    ->through(fn($institution)=>[
                        'id' => $institution->id,
                        'name' => $institution->ministry,
                        'units' => $institution->units_count ?? 0,
                        'departments' => $institution->departments_count ?? 0,
                        'staff' => $institution->departments->reduce(function($carry, $unit){
                            return $carry + $unit->all_staff;
                        }) ?? 0,
                    ]),
            'filters' => Request::only(['search']),
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
     * @param  \App\Http\Requests\StoreMinistryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMinistryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function show($ministry)
    {
        $ministry = Ministry::with('departments')->find($ministry);

        // return $ministry;

        return Inertia::render('Institution/Show', [
            'institution' => [
                'id' => $ministry->id,
                'name' => $ministry->ministry,
                // 'staff' => $ministry->ministry,
                'departments' => $ministry->departments->map(fn($department)=>[
                    'department_id' => $department->id,
                    'name' => $department->name,
                    'staff' => $department->all_staff
                ])
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function edit(Ministry $ministry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMinistryRequest  $request
     * @param  \App\Models\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMinistryRequest $request, Ministry $ministry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ministry $ministry)
    {
        //
    }
}