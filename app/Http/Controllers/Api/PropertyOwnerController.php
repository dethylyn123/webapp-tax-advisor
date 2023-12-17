<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyOwner;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyOwnerRequest;

class PropertyOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Display data based on logged user
        return PropertyOwner::where('user_id', $request->user()->id)
            ->get();

        //Display  all data; Uncomment if necessary 
        // return PropertyOwner::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(PropertyOwnerRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $propertyOwner = PropertyOwner::create($validated);

        return $propertyOwner;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PropertyOwner::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyOwnerRequest $request, string $id)
    {
        $validated = $request->validated();

        $propertyOwner = PropertyOwner::findOrFail($id);

        $propertyOwner->update($validated);

        return $propertyOwner;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $propertyOwner = PropertyOwner::findOrFail($id);
        $propertyOwner->delete();

        return $propertyOwner;
    }
}
