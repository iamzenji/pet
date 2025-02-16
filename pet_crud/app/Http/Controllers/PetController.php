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
}
