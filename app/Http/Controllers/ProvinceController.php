<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

/**
 * Controller for managing provinces in the application.
 *
 * This controller provides methods for displaying, creating, updating, and deleting provinces.
 */
class ProvinceController extends Controller
{
    /**
     * Display a listing of all provinces.
     *
     * This method retrieves all provinces from the database and displays them.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $provinces = Province::all();
        return view('provinces.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new province.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('provinces.create');
    }

    /**
     * Store a newly created province in the database.
     *
     * This method validates the request data and creates a new province entry in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod' => 'required|string|max:2',
            'nombre' => 'required|string|max:50',
        ]);

        Province::create($validated);

        return redirect()->route('provinces.index')->with('success', 'Province created successfully.');
    }

    /**
     * Show the form for editing the specified province.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\View\View
     */
    public function edit(Province $province)
    {
        return view('provinces.edit', compact('province'));
    }

    /**
     * Update the specified province in the database.
     *
     * This method validates the request data and updates the specified province entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Province $province)
    {
        $validated = $request->validate([
            'cod' => 'required|string|max:2',
            'nombre' => 'required|string|max:50',
        ]);

        $province->update($validated);

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully.');
    }

    /**
     * Remove the specified province from the database.
     *
     * This method deletes the specified province entry from the database.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
