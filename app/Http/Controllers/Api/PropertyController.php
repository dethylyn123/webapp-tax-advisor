<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Property::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(PropertyRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $property = Property::create($validated);

        return $property;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Property::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyRequest $request, string $id)
    {
        $validated = $request->validated();

        $property = Property::findOrFail($id);

        $property->update($validated);

        return $property;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return $property;
    }
}
