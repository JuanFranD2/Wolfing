<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('provinces.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod' => 'required|string|max:2',
            'nombre' => 'required|string|max:50',
        ]);

        Province::create($validated);

        return redirect()->route('provinces.index')->with('success', 'Province created successfully.');
    }

    public function edit(Province $province)
    {
        return view('provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $validated = $request->validate([
            'cod' => 'required|string|max:2',
            'nombre' => 'required|string|max:50',
        ]);

        $province->update($validated);

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully.');
    }

    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
