<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 * name="Provinces",
 * description="Operaciones relacionadas con provincias."
 * )
 */
class ProvinceController extends Controller
{
    /**
     * @OA\Get(
     * path="/provinces",
     * summary="Lista todas las provincias",
     * tags={"Provinces"},
     * @OA\Response(
     * response=200,
     * description="Lista de provincias.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Province")
     * )
     * )
     * )
     */
    public function index()
    {
        $provinces = Province::all();
        return view('provinces.index', compact('provinces'));
    }

    /**
     * @OA\Get(
     * path="/provinces/create",
     * summary="Muestra el formulario para crear una nueva provincia",
     * tags={"Provinces"},
     * @OA\Response(
     * response=200,
     * description="Formulario de creación de provincia."
     * )
     * )
     */
    public function create()
    {
        return view('provinces.create');
    }

    /**
     * @OA\Post(
     * path="/provinces",
     * summary="Almacena una nueva provincia",
     * tags={"Provinces"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/Province")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de provincias con mensaje de éxito."
     * )
     * )
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
     * @OA\Get(
     * path="/provinces/{province}/edit",
     * summary="Muestra el formulario para editar una provincia",
     * tags={"Provinces"},
     * @OA\Parameter(
     * name="province",
     * in="path",
     * required=true,
     * description="ID de la provincia a editar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario de edición de provincia."
     * )
     * )
     */
    public function edit(Province $province)
    {
        return view('provinces.edit', compact('province'));
    }

    /**
     * @OA\Put(
     * path="/provinces/{province}",
     * summary="Actualiza una provincia existente",
     * tags={"Provinces"},
     * @OA\Parameter(
     * name="province",
     * in="path",
     * required=true,
     * description="ID de la provincia a actualizar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/Province")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de provincias con mensaje de éxito."
     * )
     * )
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
     * @OA\Delete(
     * path="/provinces/{province}",
     * summary="Elimina una provincia",
     * tags={"Provinces"},
     * @OA\Parameter(
     * name="province",
     * in="path",
     * required=true,
     * description="ID de la provincia a eliminar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de provincias con mensaje de éxito."
     * )
     * )
     */
    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
