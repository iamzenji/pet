<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        return view('pets.index', ['pets' => $pets]);
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
            'type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|string',
            'color' => 'required|string',
            'size' => 'required|string',
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $pet = Pet::findOrFail($id);

        if ($pet->image) {
            unlink(storage_path('app/public/' . $pet->image));
        }

        $pet->delete();

        return redirect(route('pets.index'))->with('success', 'Pet deleted successfully!');
    }
}
