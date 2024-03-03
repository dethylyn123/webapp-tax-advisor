<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyOwner;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyOwnerRequest;
use App\Models\Property;

class PropertyOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Show data based on logged user
        $propertyOwner = PropertyOwner::where('user_id', $request->user()->id);

        // Cater Search use "keyword"
        if ($request->keyword) {
            $propertyOwner->where(function ($query) use ($request) {
                $query->where('property_owner_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('address', 'like', '%' . $request->keyword . '%');
            });
        }

        // Pagination based on number set; You can change the number below
        return $propertyOwner->paginate(10);

        // Show all date; Uncomment if necessary
        // return CarouselItems::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        // Show data based on logged user
        return PropertyOwner::where('user_id', $request->user()->id)
            ->get();
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
     * Display the property for a specific property owner.
     */
    public function viewProperty(Request $request, string $id)
    {
        // Find the property owner by id
        $propertyOwner = PropertyOwner::find($id);

        if (!$propertyOwner) {
            // Handle the case where the property owner is not found
            return response()->json(['error' => 'Property owner not found'], 404);
        }

        // Get the search keyword from the request
        $keyword = $request->input('keyword');

        // Fetch property items for the specified property_owner_id with optional search
        $query = Property::where('property_owner_id', $id);

        if ($keyword) {
            // If a keyword is provided, apply search conditions
            $query->where(function ($query) use ($keyword) {
                $query->where('property_name', 'like', '%' . $keyword . '%')
                    ->orWhere('complete_address', 'like', '%' . $keyword . '%');
            });
        }

        // Paginate the results (you can adjust the number as needed)
        $propertyItems = $query->paginate(4);

        // You can customize the response format based on your needs
        return response()->json(['property' => $propertyItems, 'property_owner' => $propertyOwner]);
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
