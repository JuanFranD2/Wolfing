<div x-data="{ showDeleteModal: false, userToDelete: null }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users') }}
            </h2>
        </x-slot>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-white">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-xl font-semibold">Users</h1>
                            <a href="{{ route('operUsers.create') }}"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                New User
                            </a>
                        </div>

                        <!-- Tabla de Oper Users -->
                        <div class="overflow-hidden w-full">
                            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            DNI
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Phone
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Email
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Type
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-32">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-700">
                                    @foreach ($users as $user)
                                        <tr class="h-16">
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->dni }}</td>
                                            <!-- DNI -->
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ ucfirst($user->type) }}</td> <!-- Mostrar el tipo -->
                                            <td
                                                class="px-4 py-2 whitespace-nowrap flex flex-wrap items-center justify-center space-y-1">
                                                <!-- Fila superior (S y M) -->
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('operUsers.show', $user->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-orange-500 rounded-md hover:bg-orange-600">
                                                        S
                                                    </a>

                                                    <a href="{{ route('operUsers.edit', $user->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                        M
                                                    </a>
                                                </div>

                                                <!-- Fila inferior (D y C) -->
                                                <div class="flex space-x-1">
                                                    <button
                                                        @click="showDeleteModal = true; userToDelete = {{ $user->id }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        D
                                                    </button>

                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- Agregar filas vacías si hay menos de 5 usuarios --}}
                                    @php
                                        $usersCount = $users->count();
                                        $rowsToAdd = 5 - $usersCount;
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
                                                <div class="flex space-x-1">
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -</button>
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -</button>
                                                </div>
                                                <div class="flex space-x-1">
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -</button>
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>
                                                        -</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>

                        <!-- Mensaje si no hay usuarios -->
                        @if ($users->isEmpty())
                            <p class="mt-4 text-white text-center">No oper users found.</p>
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
                <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this user?</p>

                <div class="mt-4 flex justify-between space-x-4">
                    <!-- Botón Cancelar -->
                    <div class="flex-1">
                        <button @click="showDeleteModal = false"
                            class="w-full px-4 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>

                    <!-- Botón Confirmar Eliminación -->
                    <div class="flex-1">
                        <form method="POST" :action="'/operUsers/' + userToDelete">
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
</div>
