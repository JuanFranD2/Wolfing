<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }} #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h1 class="mb-4 text-xl font-semibold">User #{{ $user->id }}</h1>

                    <table class="table-auto w-full border border-gray-700 dark:border-gray-600">
                        <tbody class="divide-y divide-gray-700">
                            <tr>
                                <td class="px-4 py-2 font-semibold">Name:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Email:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">DNI:</td>
                                <td>{{ $user->dni }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Phone:</td>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Address:</td>
                                <td>{{ $user->address ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">User Type:</td>
                                <td>{{ ucfirst($user->type) }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Created At:</td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Updated At:</td>
                                <td>{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <button onclick="window.history.back()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
