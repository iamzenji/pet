<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Yajra\DataTables\Facades\DataTables;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::query();

        $pets = $query->get();
        // fetch data
        return view('pets.index');
    }
    public function getPet(Request $request)
    {
        $query = Pet::query();

        // Filter data

        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        if ($request->filled('breed')) {
            $query->where('breed', 'like', '%' . $request->breed . '%');
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        // return $pets = ;
        return DataTables::make($query->get())->toJson();
    }


    public function create()
    {
        return view('pets.create');
    }

    // Input
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'breed' => 'required',
            'gender' => 'required',
            'color' => 'required',
            'size' => 'required',
            'age' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $pet = new Pet();
        $pet->type = $request->type;
        $pet->breed = $request->breed;
        $pet->gender = $request->gender;
        $pet->color = $request->color;
        $pet->size = $request->size;
        $pet->age = $request->age;
        $pet->weight = $request->weight;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
            $pet->image = $imagePath;
        }

        $pet->save();

        return response()->json([
            'success' => true,
            'message' => 'Pet added successfully!',
            'data' => $pet
        ]);
    }
    // public function edit($id)
    // {
    //     $pet = Pet::find($id);

    //     if (!$pet) {
    //         return response()->json(['error' => 'Pet not found'], 404);
    //     }

    //     return response()->json($pet);
    // }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'weight' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
            $validatedData['image'] = $imagePath;
        }

        $pet->update($validatedData); // Update pet record

        return response()->json(['success' => true, 'message' => 'Pet updated successfully!']);
    }



    // Delete
    public function destroy($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['success' => false, 'message' => 'Pet not found'], 404);
        }

        try {
            $pet->delete();
            return response()->json(['success' => true, 'message' => 'Pet deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete pet!'], 500);
        }
    }
}
