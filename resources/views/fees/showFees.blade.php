<div x-data="{ showDeleteModal: false, feeToDelete: null }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Fees') }}
            </h2>
        </x-slot>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-white">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-xl font-semibold">Fees</h1>
                            <a href="{{ route('fees.createExtraordinaryFee') }}"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                New Extraordinary Fee
                            </a>
                        </div>

                        <form action="{{ route('fees.index') }}" method="GET" class="mb-4">
                            <div class="flex items-center">
                                <input type="text" name="search" placeholder="Search by client name..."
                                    class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ request('search') }}">
                                <button type="submit"
                                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Search
                                </button>
                            </div>
                        </form>

                        <div class="overflow-hidden w-full">
                            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            CIF
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Client
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Concept
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Amount
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                            Issue Date
                                        </th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase w-32">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-900 divide-y divide-gray-700">
                                    @foreach ($fees as $fee)
                                        <tr class="h-16">
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $fee->cif }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                @if ($fee->client)
                                                    {{ $fee->client->name }}
                                                @else
                                                    Client not found
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $fee->concept }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">{{ $fee->amount }} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ $fee->passed == 'S' ? 'Paid' : 'Pending' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-white">
                                                {{ $fee->issue_date->format('Y-m-d') }}</td>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap flex flex-wrap items-center justify-center space-y-1">
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('fees.show', $fee->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-orange-500 rounded-md hover:bg-orange-600">
                                                        S
                                                    </a>

                                                    <a href="{{ route('fees.edit', $fee->id) }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                        M
                                                    </a>
                                                </div>

                                                <div class="flex space-x-1">
                                                    <button
                                                        @click="showDeleteModal = true; feeToDelete = {{ $fee->id }}"
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        D
                                                    </button>

                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- Agregar filas vacías si hay menos de 5 cuotas --}}
                                    @php
                                        $feesCount = $fees->count();
                                        $rowsToAdd = 5 - $feesCount;
                                    @endphp

                                    @for ($i = 0; $i < $rowsToAdd; $i++)
                                        <tr class="h-16">
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">-</td>
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
                                                        disabled>-</button>
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>-</button>
                                                </div>
                                                <div class="flex space-x-1">
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>-</button>
                                                    <button
                                                        class="w-6 h-6 flex items-center justify-center text-xs text-gray-400 bg-gray-700 rounded-md"
                                                        disabled>-</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $fees->links() }}
                        </div>

                        @if ($fees->isEmpty())
                            <p class="mt-4 text-white text-center">No fees found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showDeleteModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Confirm Deletion</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this fee?</p>

                <div class="mt-4 flex justify-between space-x-4">
                    <div class="flex-1">
                        <button @click="showDeleteModal = false"
                            class="w-full px-4 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>

                    <div class="flex-1">
                        <form method="POST" :action="'/fees/' + feeToDelete">
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
