<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RealPropertyTax;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealPropertyTaxRequest;

class RealPropertyTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RealPropertyTax::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(RealPropertyTaxRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $propertyOwner = RealPropertyTax::create($validated);

        return $propertyOwner;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return RealPropertyTax::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(RealPropertyTaxRequest $request, string $id)
    {
        $validated = $request->validated();

        $propertyOwner = RealPropertyTax::findOrFail($id);

        $propertyOwner->update($validated);

        return $propertyOwner;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $propertyOwner = RealPropertyTax::findOrFail($id);
        $propertyOwner->delete();

        return $propertyOwner;
    }
}
