<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use Inertia\Inertia;
use Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Person/Index', [
            'people' => Person::query()
                        ->when(request()->search, function($query, $search){
                            $terms = explode(" ", $search);
                            foreach($terms as $term){
                                $query->where('surname', 'like', "%{$term}%");
                                $query->orWhere('other_names', 'like', "%{$term}%");
                                $query->orWhere('date_of_birth', 'like', "%{$term}%");
                                $query->orWhereRaw('MONTHNAME(date_of_birth) like ?', "%{$term}%");
                                $query->orWhere('social_security_number', 'like', "%{$term}%");
                            }
                        })
                        ->paginate()
                        ->withQueryString()
                        ->through(fn($person) => [
                            'id' => $person->id,
                            'name' => $person->full_name,
                            'gender' => $person ->gender,
                            'dob' => $person ->date_of_birth,
                            'ssn' => $person ->social_security_number,
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
     * @param  \App\Http\Requests\StorePersonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return Inertia::render('Person/Show', [
            'person' => [
                'name' => $person->full_name,
                'dob' => $person->date_of_birth,
                'ssn' => $person->social_security_number,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonRequest  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}