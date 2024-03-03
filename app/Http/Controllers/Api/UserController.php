<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // // Show data based on logged user
        // $user = User::all();

        // // Cater Search use "keyword"
        // if ($request->keyword) {
        //     $user->where(function ($query) use ($request) {
        //         $query->where('lastname', 'like', '%' . $request->keyword . '%')
        //             ->orWhere('firstname', 'like', '%' . $request->keyword . '%');
        //     });
        // }

        // // Pagination based on number set; You can change the number below
        // return $user->paginate(3);

        // // Show all data; Uncomment if necessary
        // // return User::all();

        // Query builder instance
        $query = User::query();

        // Cater Search use "keyword"
        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('lastname', 'like', '%' . $request->keyword . '%')
                    ->orWhere('firstname', 'like', '%' . $request->keyword . '%');
            });
        }

        // Pagination based on the number set; You can change the number below
        $perPage = 4;
        return $query->paginate($perPage);

        // Show all data; Uncomment if necessary
        // return User::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        // Show data based on logged user
        return User::all();
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
    public function store(UserRequest $request)
    {
        // $validated = $request->validated();

        // $validated['password'] = Hash::make($validated['password']);

        // $user = User::create($validated);

        // return $user;

        // Retrieve the validated input data...
        $validated = $request->validated();

        // Store in carousel folder the image
        $validated['image'] = $request->file('image')->storePublicly('user', 'public');

        $user = User::create($validated);

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $validated = $request->validated();

        // Check if a file was uploaded
        if ($request->hasFile('image')) {
            // Upload Image to Backend and Store Image Path
            $validated['image'] = $request->file('image')->storePublicly('user', 'public');
        }

        // Get Info by Id 
        $user = User::findOrFail($id);

        // Update password only if provided
        if (isset($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        // Delete Previous Image
        if (!is_null($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // Remove 'password' from $validated array to prevent setting it to null
        unset($validated['password']);

        // Update other information
        $user->update($validated);

        return $user;
    }



    /**
     * Update the name of the specified resource in storage.
     */
    public function name(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        $user->name = $validated['name'];

        $user->save();

        return $user;
    }

    /**
     * Update the email of the specified resource in storage.
     */
    public function email(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        $user->email = $validated['email'];

        $user->save();

        return $user;
    }

    /**
     * Update the password of the specified resource in storage.
     */
    public function password(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validate old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $validated = $request->validated();

        $user->password = Hash::make($validated['password']);

        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    /**
     * Update the image of the specified resource from storage.
     */
    public function image(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        if (!is_null($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->image = $request->file('image')->storePublicly('images', 'public');

        $user->save();

        return $user;
    }
}
