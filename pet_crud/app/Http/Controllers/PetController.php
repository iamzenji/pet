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
        $data = $request->validate([
            'type' => 'required|string',
            'breed' => 'required|string',
            'gender' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        // insert data
        Pet::create($data);

        return redirect(route('pets.index'))->with('success', 'Pet added successfully!');
    }


    // Edit
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type'   => 'required|string|max:255',
            'breed'  => 'required|string|max:255',
            'gender' => 'required|string',
            'color'  => 'required|string',
            'size'   => 'required|string',
            'age'    => 'required|integer',
            'weight' => 'required|numeric',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pet = Pet::findOrFail($id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect(route('pets.index'))->with('success', 'Pet updated successfully!');
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
