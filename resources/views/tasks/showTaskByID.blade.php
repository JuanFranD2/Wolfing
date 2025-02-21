<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h1 class="mb-4 text-xl font-semibold">Task #{{ $task->id }}</h1>

                    <table class="table-auto w-full border border-gray-700 dark:border-gray-600">
                        <tbody class="divide-y divide-gray-700">
                            <!-- Row 1: Client and Contact Person -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Client:</td>
                                <td>{{ $task->client }}</td>
                                <td class="px-4 py-2 font-semibold">Contact Person:</td>
                                <td>{{ $task->contact_person }}</td>
                            </tr>

                            <!-- Row 2: Contact Email and Contact Phone -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Contact Email:</td>
                                <td>{{ $task->contact_email }}</td>
                                <td class="px-4 py-2 font-semibold">Contact Phone:</td>
                                <td>{{ $task->contact_phone }}</td>
                            </tr>

                            <!-- Row 3: Description -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Description:</td>
                                <td colspan="3">{{ $task->description }}</td>
                            </tr>

                            <!-- Row 4: Address and City -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Address:</td>
                                <td>{{ $task->address }}</td>
                                <td class="px-4 py-2 font-semibold">City:</td>
                                <td>{{ $task->city }}</td>
                            </tr>

                            <!-- Row 5: Postal Code and Province -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Postal Code:</td>
                                <td>{{ $task->postal_code }}</td>
                                <td class="px-4 py-2 font-semibold">Province:</td>
                                <td>{{ $task->prov ? $task->prov->name : 'No province assigned' }}</td>
                            </tr>

                            <!-- Row 6: Assigned Operator and Status -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Assigned Operator:</td>
                                <td>{{ $task->operator ? $task->operator->name : 'No operator assigned' }}</td>
                                <td class="px-4 py-2 font-semibold">Status:</td>
                                <td>
                                    @if ($task->status == 'P')
                                        Pending Approval...
                                    @elseif ($task->status == 'R')
                                        Completed
                                    @elseif ($task->status == 'E')
                                        In Progress...
                                    @elseif ($task->status == 'C')
                                        Under Review...
                                    @elseif ($task->status == 'X')
                                        Cancelled
                                    @endif
                                </td>
                            </tr>

                            <!-- Row 7: Previous Notes -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Previous Notes:</td>
                                <td colspan="3">{{ $task->previous_notes }}</td>
                            </tr>

                            <!-- Row 8: Subsequent Notes -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Subsequent Notes:</td>
                                <td colspan="3">{{ $task->subsequent_notes }}</td>
                            </tr>

                            <!-- Row 8: Summary File -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Summary File:</td>
                                <td colspan="3">
                                    @if ($task->summary_file)
                                        <a href="{{ asset('storage/' . $task->summary_file) }}" target="_blank"
                                            class="text-blue-600 underline">Summary File</a>
                                    @else
                                        No summary file uploaded.
                                    @endif
                                </td>
                            </tr>

                            <!-- Row 9: Created At, Updated At, and Realization Date -->
                            <tr>
                                <td class="px-4 py-2 font-semibold">Created At:</td>
                                <td>{{ $task->created_at }}</td>
                                <td class="px-4 py-2 font-semibold">Updated At:</td>
                                <td>{{ $task->updated_at }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Realization Date:</td>
                                <td>{{ $task->realization_date }}</td>
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
