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

/**
 * Controller for managing tasks in the application.
 *
 * This controller provides methods for displaying, creating, updating, completing, 
 * and deleting tasks based on user roles (admin, oper, client).
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * This method retrieves tasks based on the user's role (admin, oper) 
     * and the task status, displaying them accordingly.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // Default to 'all' if no status is provided.

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Filtrar tareas según el tipo de usuario y el estado
        if ($user->type == 'admin') {
            if ($status === 'all') {
                $tasks = Task::latest('updated_at')->paginate(5); // Obtener todas las tareas, ordenadas por 'updated_at'
            } else {
                $tasks = Task::where('status', $status)->latest('updated_at')->paginate(5); // Filtrar por estado y ordenar
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

    /**
     * Display the specified task.
     *
     * This method retrieves a specific task by ID along with its associated province and operator.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Usamos with() para cargar la relación 'province' y obtener la provincia completa
        $task = Task::with('prov', 'operator')->findOrFail($id);

        // Pasamos la tarea a la vista
        return view('tasks.showTaskByID', compact('task'));
    }

    /**
     * Delete the specified task.
     *
     * This method deletes a task by its ID and redirects back with a success message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    /**
     * Show the form to complete a task.
     *
     * This method loads the task completion form and the related provinces for the task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function showCompleteTask(Task $task)
    {
        // Obtener las provincias si es necesario
        $provinces = Province::all();

        // Pasar la tarea y las provincias a la vista
        return view('tasks.completeTaskOper', compact('task', 'provinces'));
    }

    /**
     * Complete a task.
     *
     * This method updates the task status, uploads the summary file, and saves the changes.
     *
     * @param  \App\Http\Requests\CompleteTaskRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeTask(CompleteTaskRequest $request, $id)
    {
        // Buscar la tarea por su ID
        $task = Task::findOrFail($id);

        // Validar y manejar el archivo de resumen si se ha subido
        $summaryFilePath = null;
        if ($request->hasFile('summary_file')) {
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

    /**
     * Show the form for creating a new task.
     *
     * This method shows the task creation form based on the user's role (admin, client).
     *
     */
    public function create()
    {
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.newTaskAdmin', compact('provinces', 'operators'));
    }

    public function createClient()
    {
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.newTaskClient', compact('provinces', 'operators'));
    }


    /**
     * Show the form for editing an existing task.
     *
     * This method retrieves the task and necessary data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.modifyTaskAdmin', compact('task', 'provinces', 'operators'));
    }

    /**
     * Store a newly created task in storage.
     *
     * This method stores a new task in the database using validated data from the request.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Update the specified task in storage.
     *
     * This method updates the task with the given ID using validated data and file handling.
     *
     * @param  \App\Http\Requests\ModifyTaskRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ModifyTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);

        $summaryFilePath = null;
        if ($request->hasFile('summary_file')) {
            $fileName = 'summary_' . $task->id . '.' . $request->file('summary_file')->getClientOriginalExtension();
            $summaryFilePath = $request->file('summary_file')->storeAs('tasks/' . $task->id, $fileName, 'public');
        } else {
            $summaryFilePath = $task->summary_file;
        }

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
            'summary_file' => $summaryFilePath,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Store a newly created task for the client.
     *
     * This method stores a task created by a client with validated data.
     *
     * @param  \App\Http\Requests\NewTaskClientRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeClientTask(NewTaskClientRequest $request)
    {
        $validated = $request->validated();
        $client = Client::where('cif', $request->input('cif'))->first();

        Task::create([
            'client' => $client->name,
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

        return redirect()->route('tasks.thanks.client')->with('task_created', 'Task created successfully!');
    }
}
