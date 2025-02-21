<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Client Details') }} #{{ $client->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h1 class="mb-4 text-xl font-semibold">Client #{{ $client->id }}</h1>

                    <table class="table-auto w-full border border-gray-700 dark:border-gray-600">
                        <tbody class="divide-y divide-gray-700">
                            <tr>
                                <td class="px-4 py-2 font-semibold">CIF:</td>
                                <td>{{ $client->cif }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Name:</td>
                                <td>{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Phone:</td>
                                <td>{{ $client->phone }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Email:</td>
                                <td>{{ $client->email }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Bank Account:</td>
                                <td>{{ $client->bank_account ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Country:</td>
                                <td>{{ $client->country ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Currency:</td>
                                <td>{{ $client->currency ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Monthly Fee:</td>
                                <td>{{ $client->monthly_fee }} €</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Created At:</td>
                                <td>{{ $client->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Updated At:</td>
                                <td>{{ $client->updated_at->format('Y-m-d H:i') }}</td>
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
