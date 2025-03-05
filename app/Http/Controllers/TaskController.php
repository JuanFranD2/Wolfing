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
 * @OA\Info(
 * title="Task API",
 * version="1.0.0",
 * description="API para gestionar tareas."
 * )
 */
class TaskController extends Controller
{

    /**
     * Lista de tareas.
     *
     * @OA\Get(
     * path="/api/tasks",
     * summary="Obtiene una lista de tareas.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="status",
     * in="query",
     * description="Filtrar por estado (all, P, E, C).",
     * required=false,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Lista de tareas obtenida exitosamente.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Task")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="No autorizado."
     * )
     * )
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
     * Mostrar detalles de una tarea específica.
     *
     * @OA\Get(
     * path="/api/tasks/{id}",
     * summary="Obtiene los detalles de una tarea específica.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalles de la tarea obtenidos exitosamente.",
     * @OA\JsonContent(ref="#/components/schemas/Task")
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * )
     * )
     */
    public function show($id)
    {
        // Usamos with() para cargar la relación 'province' y obtener la provincia completa
        $task = Task::with('prov', 'operator')->findOrFail($id);

        // Pasamos la tarea a la vista
        return view('tasks.showTaskByID', compact('task'));
    }

    /**
     * Eliminar una tarea específica.
     *
     * @OA\Delete(
     * path="/api/tasks/{id}",
     * summary="Elimina una tarea específica.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea a eliminar.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Tarea eliminada exitosamente."
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * )
     * )
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task marked as completed.');
    }

    /**
     * Mostrar formulario para completar una tarea.
     *
     * @OA\Get(
     * path="/api/tasks/{id}/complete",
     * summary="Muestra el formulario para completar una tarea.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea a completar.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario para completar la tarea mostrado exitosamente."
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * )
     * )
     */
    public function showCompleteTask(Task $task)
    {
        // Obtener las provincias si es necesario
        $provinces = Province::all();

        // Pasar la tarea y las provincias a la vista
        return view('tasks.completeTaskOper', compact('task', 'provinces'));
    }

    /**
     * Completar una tarea.
     *
     * @OA\Post(
     * path="/api/tasks/{id}/complete",
     * summary="Completa una tarea específica.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea a completar.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/CompleteTaskRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Tarea completada exitosamente."
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * )
     * )
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
     * Mostrar formulario para crear una nueva tarea.
     *
     * @OA\Get(
     * path="/api/tasks/create",
     * summary="Muestra el formulario para crear una nueva tarea.",
     * tags={"Tareas"},
     * @OA\Response(
     * response=200,
     * description="Formulario para crear la tarea mostrado exitosamente."
     * )
     * )
     */
    public function create()
    {
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.newTaskAdmin', compact('provinces', 'operators'));
    }

    /**
     * Mostrar formulario para crear una nueva tarea para un cliente.
     *
     * @OA\Get(
     * path="/api/tasks/create/client",
     * summary="Muestra el formulario para crear una nueva tarea para un cliente.",
     * tags={"Tareas"},
     * @OA\Response(
     * response=200,
     * description="Formulario para crear la tarea para el cliente mostrado exitosamente."
     * )
     * )
     */
    public function createClient()
    {
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.newTaskClient', compact('provinces', 'operators'));
    }


    /**
     * Mostrar formulario para editar una tarea existente.
     *
     * @OA\Get(
     * path="/api/tasks/{id}/edit",
     * summary="Muestra el formulario para editar una tarea existente.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea a editar.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Formulario para editar la tarea mostrado exitosamente."
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * )
     * )
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $provinces = Province::all();
        $operators = User::where('type', 'oper')->get(['id', 'name']);

        return view('tasks.modifyTaskAdmin', compact('task', 'provinces', 'operators'));
    }

    /**
     * Almacenar una nueva tarea en el almacenamiento.
     *
     * @OA\Post(
     * path="/api/tasks",
     * summary="Almacena una nueva tarea.",
     * tags={"Tareas"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Tarea creada exitosamente."
     * ),
     * @OA\Response(
     * response=422,
     * description="Datos de entrada no válidos."
     * )
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Actualizar una tarea específica en el almacenamiento.
     *
     * @OA\Put(
     * path="/api/tasks/{id}",
     * summary="Actualiza una tarea específica.",
     * tags={"Tareas"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la tarea a actualizar.",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/ModifyTaskRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Tarea actualizada exitosamente."
     * ),
     * @OA\Response(
     * response=404,
     * description="Tarea no encontrada."
     * ),
     * @OA\Response(
     * response=422,
     * description="Datos de entrada no válidos."
     * )
     * )
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
     * Almacenar una nueva tarea para el cliente.
     *
     * @OA\Post(
     * path="/api/tasks/client",
     * summary="Almacena una nueva tarea creada por un cliente.",
     * tags={"Tareas"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/NewTaskClientRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Tarea creada por el cliente exitosamente."
     * ),
     * @OA\Response(
     * response=422,
     * description="Datos de entrada no válidos."
     * )
     * )
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
