<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyOperUserRequest;
use App\Http\Requests\StoreOperUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing operational users in the application.
 *
 * This controller provides methods to create, read, update, and delete
 * operational users. It also manages the display of user lists and 
 * user details.
 */
class OperUserController extends Controller
{
    /**
     * Display a listing of the operational users.
     *
     * This method retrieves all users, excluding the currently authenticated user,
     * and displays them in a paginated list.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Paginación para obtener todos los usuarios, excluyendo el usuario actual
        $users = User::where('id', '!=', Auth::id())->paginate(5);  // Cambia el número 5 por la cantidad que desees
        return view('users.operUsers', compact('users'));
    }

    /**
     * Show the form for creating a new operational user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.newOperUser');
    }

    /**
     * Store a newly created operational user in storage.
     *
     * This method validates the request data and creates a new user in the database.
     *
     * @param  \App\Http\Requests\StoreOperUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified operational user.
     *
     * This method retrieves the user by their ID and displays the user's details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Encuentra al usuario por su ID
        return view('users.showUserByID', compact('user'));
    }

    /**
     * Show the form for editing the specified operational user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.modifyOperUser', compact('user'));
    }

    /**
     * Update the specified operational user in storage.
     *
     * This method validates the request data, updates the user information,
     * and saves the changes to the database. If a new password is provided, it is encrypted.
     *
     * @param  \App\Http\Requests\ModifyOperUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
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
     * Remove the specified operational user from storage.
     *
     * This method deletes the user from the database and returns a success message.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
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
