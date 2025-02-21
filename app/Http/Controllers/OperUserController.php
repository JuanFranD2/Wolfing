<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyOperUserRequest;
use App\Http\Requests\StoreOperUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginación para obtener todos los usuarios, excluyendo el usuario actual
        $users = User::where('id', '!=', Auth::id())->paginate(5);  // Cambia el número 5 por la cantidad que desees
        return view('users.operUsers', compact('users'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.newOperUser');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Encuentra al usuario por su ID
        return view('users.showUserByID', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        return view('users.modifyOperUser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
