<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteTaskRequest;
use App\Http\Requests\ModifyTaskRequest;
use App\Http\Requests\NewTaskClientRequest;
use App\Models\Province;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // Default to 'all' if no status is provided.

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Filtrar tareas según el tipo de usuario y el estado
        if ($user->type == 'admin') {
            if ($status === 'all') {
                $tasks = Task::latest('updated_at')->paginate(5); // Obtener todas las tareas, ordenadas por 'updated_at' de más reciente a más antigua
            } else {
                $tasks = Task::where('status', $status)->latest('updated_at')->paginate(5); // Filtrar por estado y ordenar por 'updated_at'
            }
            return view('tasks.adminTasks', compact('tasks'));
        } elseif ($user->type == 'oper') {
            // Solo mostrar tareas asignadas a este operario y con estatus 'E' (In Progress)
            $tasks = Task::where('assigned_operator', $user->id)
                ->where('status', 'E') // Filtro para el estado 'E' (In Progress)
                ->latest('updated_at') // Ordenar por la fecha de actualización más reciente
                ->paginate(5);

            return view('tasks.operTasks', compact('tasks'));
        } else {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    }

    public function show($id)
    {
        // Usamos with() para cargar la relación 'province' y obtener la provincia completa
        $task = Task::with('prov', 'operator')->findOrFail($id);

        // Pasamos la tarea a la vista
        return view('tasks.showTaskByID', compact('task'));
    }



    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    /**
     * Show the form to complete a task.
     */
    public function showCompleteTask(Task $task)
    {
        // Obtener las provincias si es necesario
        $provinces = Province::all();

        // Pasar la tarea y las provincias a la vista
        return view('tasks.completeTaskOper', compact('task', 'provinces'));
    }

    public function completeTask(CompleteTaskRequest $request, $id)
    {
        // Buscar la tarea por su ID
        $task = Task::findOrFail($id);

        // Validar y manejar el archivo de resumen si se ha subido
        $summaryFilePath = null;
        if ($request->hasFile('summary_file')) {
            // Generar una ruta única para el archivo
            $fileName = 'summary_' . $task->id . '.' . $request->file('summary_file')->getClientOriginalExtension();
            $summaryFilePath = $request->file('summary_file')->storeAs('tasks/' . $task->id, $fileName, 'public');
        }

        // Validar y obtener los datos de la solicitud
        $validatedData = $request->validated();

        // Actualizar el estado de la tarea con el valor validado
        $task->status = $validatedData['status'];

        // Solo actualizamos el archivo de resumen si se ha subido uno nuevo
        if ($summaryFilePath) {
            $task->summary_file = $summaryFilePath;
        }

        // Actualizar las notas posteriores
        $task->subsequent_notes = $validatedData['subsequent_notes'];

        // Actualizar la fecha de realización si es necesario
        $task->realization_date = now();

        // Guardar los cambios en la tarea
        $task->save();

        // Redirigir de vuelta a la lista de tareas con un mensaje de éxito
        return redirect()->route('tasks.index')->with('success', 'Task completed successfully.');
    }


    public function formCreate()
    {
        // Obtener todas las provincias
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        // Verificar el tipo de usuario y cargar la vista correspondiente
        if (Auth::user()->type === 'admin') {
            return view('tasks.newTaskAdmin', compact('provinces', 'operators'));
        } elseif (Auth::user()->type === 'client') {
            return view('tasks.newTaskClient', compact('provinces', 'operators'));
        }

        // Si el usuario no es admin ni client, se redirige a alguna otra vista o se lanza un error
        return redirect()->route('tasks.index')->with('error', 'Unauthorized access');
    }

    public function formEdit($id)
    {
        // Obtener la tarea por su ID
        $task = Task::findOrFail($id);

        // Obtener todas las provincias
        $provinces = Province::all();

        // Obtener los operadores de tipo 'oper'
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        // Retornar la vista con los datos necesarios
        return view('tasks.modifyTaskAdmin', compact('task', 'provinces', 'operators'));
    }


    public function store(StoreTaskRequest $request)
    {
        // Crear una nueva tarea con los datos validados
        Task::create($request->validated());

        // Redirigir a la lista de tareas con un mensaje de éxito
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(ModifyTaskRequest $request, $id)
    {
        // Obtener la tarea que vamos a actualizar
        $task = Task::findOrFail($id);

        // Validar y manejar el archivo de resumen si se ha subido
        $summaryFilePath = null;
        if ($request->hasFile('summary_file')) {
            // Generar una ruta única para el archivo
            $fileName = 'summary_' . $task->id . '.' . $request->file('summary_file')->getClientOriginalExtension();
            $summaryFilePath = $request->file('summary_file')->storeAs('tasks/' . $task->id, $fileName, 'public');
        } else {
            // Si no hay un archivo nuevo, mantener el archivo actual
            $summaryFilePath = $task->summary_file;
        }

        // Actualizar la tarea con los datos del formulario
        $task->update([
            'client' => $request->client,
            'contact_person' => $request->contact_person,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'province' => $request->province,
            'assigned_operator' => $request->assigned_operator,
            'status' => $request->status,
            'realization_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'previous_notes' => $request->previous_notes,
            'subsequent_notes' => $request->subsequent_notes,
            'summary_file' => $summaryFilePath, // Guardamos la ruta del archivo
        ]);

        // Redirigir a la vista de tareas con un mensaje de éxito
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function createTaskClient()
    {
        // Obtener las provincias disponibles para el formulario
        $provinces = Province::all();
        return view('tasks.newTaskClient', compact('provinces'));
    }

    /**
     * Store a newly created task in storage for the client.
     */
    public function storeClientTask(NewTaskClientRequest $request)
    {
        // Los datos ya han sido validados gracias al NewTaskClientRequest
        $validated = $request->validated();

        // Obtener el cliente por CIF
        $client = Client::where('cif', $request->input('cif'))->first();

        // Crear la tarea con los datos validados
        Task::create([
            'client' => $client->name,  // Usar el nombre del cliente en lugar del CIF
            'contact_person' => $validated['contact_person'],
            'contact_phone' => $validated['contact_phone'],
            'description' => $validated['description'],
            'contact_email' => $validated['contact_email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'province' => $validated['province'],
            'previous_notes' => $validated['previous_notes'],
            'status' => 'P', // "Pending" por defecto
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('tasks.thanks.client')->with('task_created', 'Task created successfully!');
    }
}
