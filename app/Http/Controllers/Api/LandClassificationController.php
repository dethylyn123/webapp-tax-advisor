<?php

namespace App\Http\Controllers\Api;

use App\Models\LandClassification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LandClassificationRequest;

class LandClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LandClassification::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(LandClassificationRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $landClassification = LandClassification::create($validated);

        return $landClassification;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return LandClassification::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LandClassificationRequest $request, string $id)
    {
        $validated = $request->validated();

        $landClassification = LandClassification::findOrFail($id);

        $landClassification->update($validated);

        return $landClassification;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $landClassification = LandClassification::findOrFail($id);
        $landClassification->delete();

        return $landClassification;
    }
}
