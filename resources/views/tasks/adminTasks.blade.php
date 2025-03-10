<div x-data="{ showDeleteModal: false, taskToDelete: null }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tasks Admin') }}
            </h2>
        </x-slot>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-white">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-xl font-semibold">Tasks</h1>

                            <form action="{{ route('tasks.index') }}" method="GET" class="flex space-x-4">
                                <select name="status" id="status"
                                    class="px-4 py-0 bg-purple-600 text-white rounded-md hover:bg-purple-900">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Tasks
                                    </option>
                                    <option value="P" {{ request('status') == 'P' ? 'selected' : '' }}>Tasks
                                        Pending Approval</option>
                                    <option value="E" {{ request('status') == 'E' ? 'selected' : '' }}>Tasks In
                                        Progress</option>
                                    <option value="R" {{ request('status') == 'R' ? 'selected' : '' }}>Tasks
                                        Completed</option>
                                    <option value="C" {{ request('status') == 'C' ? 'selected' : '' }}>Tasks Under
                                        Review</option>
                                    <option value="X" {{ request('status') == 'X' ? 'selected' : '' }}>Tasks
                                        Cancelled</option>
                                </select>
                                <button type="submit"
                                    class="px-4 py-0 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filter</button>
                            </form>


                            <a href="{{ route('tasks.formCreateAdmin') }}"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                New Task
                            </a>
                        </div>

                        <!-- Tabla de Tareas -->
                        <div class="overflow-hidden w-full">
                            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Client
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Contact Person
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Contact Phone
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Created At
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-32">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-700">
                                    @foreach ($tasks as $task)
                                        <tr class="h-16">
                                            <td class="px-6 py-4 whitespace-nowrap text-white" hidden>
                                                {{ $task->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $task->client }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ $task->contact_person }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ $task->contact_phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                <div class="{{ $task->status_class }}">
                                                    {{ $task->status_description }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ $task->created_at->format('Y-m-d H:i') }}</td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap flex flex-wrap items-center justify-center space-y-1">
                                                <!-- Fila superior (S y M) -->
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('tasks.show', $task->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-orange-500 rounded-md hover:bg-orange-600">
                                                        S
                                                    </a>

                                                    <a href="{{ route('tasks.formEdit', $task->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                        M
                                                    </a>
                                                </div>

                                                <!-- Fila inferior (D y C) -->
                                                <div class="flex space-x-1">
                                                    <button
                                                        @click="showDeleteModal = true; taskToDelete = {{ $task->id }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        D
                                                    </button>
                                                    <button type="submit"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md cursor-not-allowed"
                                                        disabled>

                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- Agregar filas vacías si hay menos de 5 tareas en la última página --}}
                                    @php
                                        $tasksCount = $tasks->count();
                                        $rowsToAdd = 5 - $tasksCount;
                                    @endphp

                                    @for ($i = 0; $i < $rowsToAdd; $i++)
                                        <tr class="h-16">
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap flex flex-wrap items-center justify-center space-y-1">
                                                <!-- Fila superior (S y M) -->
                                                <div class="flex space-x-1">
                                                    <a class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -
                                                    </a>

                                                    <a class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -
                                                    </a>
                                                </div>

                                                <!-- Fila inferior (D y C) -->
                                                <div class="flex space-x-1">
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -
                                                    </button>

                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $tasks->appends(['status' => request('status')])->links() }}
                        </div>

                        <!-- Mensaje si no hay tareas -->
                        @if ($tasks->isEmpty())
                            <p class="mt-4 text-white text-center">No tasks found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div x-show="showDeleteModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Confirm Deletion</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this task?</p>

                <!-- Contenedor para los botones, con flexbox para alinearlos -->
                <div class="mt-4 flex justify-between space-x-4"> <!-- Centrado y espaciado entre los botones -->

                    <!-- Botón Cancel -->
                    <div class="flex-1">
                        <button @click="showDeleteModal = false"
                            class="w-full px-4 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>

                    <!-- Botón Confirm Delete -->
                    <div class="flex-1">
                        <form method="POST" :action="'/tasks/' + taskToDelete">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-4 py-3 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Confirm Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
