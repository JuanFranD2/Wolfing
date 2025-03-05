<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyOperUserRequest;
use App\Http\Requests\StoreOperUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 * name="Operational Users",
 * description="Operaciones relacionadas con usuarios operativos."
 * )
 */
class OperUserController extends Controller
{
    /**
     * @OA\Get(
     * path="/operUsers",
     * summary="Lista todos los usuarios operativos",
     * tags={"Operational Users"},
     * @OA\Response(
     * response=200,
     * description="Lista de usuarios operativos.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/User")
     * )
     * )
     * )
     */
    public function index()
    {
        // Paginación para obtener todos los usuarios, excluyendo el usuario actual
        $users = User::where('id', '!=', Auth::id())->paginate(5);  // Cambia el número 5 por la cantidad que desees
        return view('users.operUsers', compact('users'));
    }

    /**
     * @OA\Get(
     * path="/operUsers/create",
     * summary="Muestra el formulario para crear un nuevo usuario operativo",
     * tags={"Operational Users"},
     * @OA\Response(
     * response=200,
     * description="Formulario de creación de usuario operativo."
     * )
     * )
     */
    public function create()
    {
        return view('users.newOperUser');
    }

    /**
     * @OA\Post(
     * path="/operUsers",
     * summary="Almacena un nuevo usuario operativo",
     * tags={"Operational Users"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreOperUserRequest")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de usuarios operativos con mensaje de éxito."
     * )
     * )
     */
    public function store(StoreOperUserRequest $request)
    {
        // Usar los datos validados directamente del request
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'dni' => $request->dni,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type, // Ahora tomamos el tipo de usuario directamente del request
        ]);

        return redirect()->route('operUsers.index')->with('success', 'Oper user created successfully.');
    }

    /**
     * @OA\Get(
     * path="/operUsers/{id}",
     * summary="Muestra los detalles de un usuario operativo",
     * tags={"Operational Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID del usuario operativo.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalles del usuario operativo.",
     * @OA\JsonContent(ref="#/components/schemas/User")
     * )
     * )
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Encuentra al usuario por su ID
        return view('users.showUserByID', compact('user'));
    }

    /**
     * @OA\Get(
     * path="/operUsers/{user}/edit",
     * summary="Muestra el formulario para editar un usuario operativo",
     * tags={"Operational Users"},
     * @OA\Parameter(
     * name="user",
     * in="path",
     * required=true,
     * description="ID del usuario operativo a editar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario de edición de usuario operativo."
     * )
     * )
     */
    public function edit(User $user)
    {
        return view('users.modifyOperUser', compact('user'));
    }

    /**
     * @OA\Put(
     * path="/operUsers/{id}",
     * summary="Actualiza un usuario operativo existente",
     * tags={"Operational Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID del usuario operativo a actualizar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/ModifyOperUserRequest")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de usuarios operativos con mensaje de éxito."
     * )
     * )
     */
    public function update(ModifyOperUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // Si se ha proporcionado una nueva contraseña, encríptala antes de guardar
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Actualiza los demás campos
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dni = $request->dni;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->type = $request->type;

        $user->save();

        return redirect()->route('operUsers.index')->with('success', 'User updated successfully.');
    }

    /**
     * @OA\Delete(
     * path="/operUsers/{id}",
     * summary="Elimina un usuario operativo",
     * tags={"Operational Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID del usuario operativo a eliminar.",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=302,
     * description="Redirecciona a la lista de usuarios operativos con mensaje de éxito."
     * )
     * )
     */
    public function destroy(string $id)
    {
        // Buscar al usuario por su ID
        $user = User::findOrFail($id);

        // Eliminar al usuario
        $user->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('operUsers.index')->with('success', 'User deleted successfully.');
    }
}
