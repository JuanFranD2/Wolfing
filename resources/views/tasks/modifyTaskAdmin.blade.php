<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modify Task') }} #{{ $task->id }} </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Row 1: Client, Contact Person, Contact Email, Contact Phone -->
                    <div class="grid
                    grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                        <div>
                            <input type="hidden" name="status" id="status" value="E">
                            <label for="client" class="block text-gray-700 dark:text-gray-200">Client</label>
                            <input type="text" name="client" id="client"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('client', $task->client) }}">
                            <div class='h5'>
                                @error('client')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="contact_person" class="block text-gray-700 dark:text-gray-200">Contact
                                Person</label>
                            <input type="text" name="contact_person" id="contact_person"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('contact_person', $task->contact_person) }}">
                            <div class='h5'>
                                @error('contact_person')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="contact_email" class="block text-gray-700 dark:text-gray-200">Contact
                                Email</label>
                            <input type="email" name="contact_email" id="contact_email"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('contact_email', $task->contact_email) }}">
                            <div class='h5'>
                                @error('contact_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-gray-700 dark:text-gray-200">Contact
                                Phone</label>
                            <input type="text" name="contact_phone" id="contact_phone"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('contact_phone', $task->contact_phone) }}">
                            <div class='h5'>
                                @error('contact_phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Description -->
                    <div class="gap-2 mb-2">
                        <label for="description" class="block text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $task->description) }}</textarea>
                        <div class='h5'>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 3: Address, Postal Code, City, Province -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                        <div>
                            <label for="address" class="block text-gray-700 dark:text-gray-200">Address</label>
                            <input type="text" name="address" id="address"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('address', $task->address) }}">
                            <div class='h5'>
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="postal_code" class="block text-gray-700 dark:text-gray-200">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('postal_code', $task->postal_code) }}">
                            <div class='h5'>
                                @error('postal_code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="city" class="block text-gray-700 dark:text-gray-200">City</label>
                            <input type="text" name="city" id="city"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('city', $task->city) }}">
                            <div class='h5'>
                                @error('city')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="province" class="block text-gray-700 dark:text-gray-200">Province</label>
                            <select name="province" id="province"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select a province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->cod }}"
                                        {{ old('province', $task->province) == $province->cod ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class='h5'>
                                @error('province')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Previous Notes -->
                    <div class="gap-2 mb-2">
                        <label for="previous_notes" class="block text-gray-700 dark:text-gray-200">Previous
                            Notes</label>
                        <textarea name="previous_notes" id="previous_notes" rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('previous_notes', $task->previous_notes) }}</textarea>
                        <div class='h5'>
                            @error('previous_notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 5: Subsequent Notes -->
                    <div class="gap-2 mb-2">
                        <label for="subsequent_notes" class="block text-gray-700 dark:text-gray-200">Subsequent
                            Notes</label>
                        <textarea name="subsequent_notes" id="subsequent_notes" rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('subsequent_notes', $task->subsequent_notes) }}</textarea>
                        <div class='h5'>
                            @error('subsequent_notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 6: Summary File -->
                    <div class="gap-2 mb-2">
                        <label for="summary_file" class="block text-gray-700 dark:text-gray-200">Summary File (PDF
                            only, max 10MB)</label>
                        <input type="file" name="summary_file" id="summary_file"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        @if ($task->summary_file)
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Current file:
                                <a href="{{ url('storage/' . $task->summary_file) }}" target="_blank"
                                    class="text-blue-600 underline">
                                    {{ basename($task->summary_file) }} <!-- Mostrar solo el nombre del archivo -->
                                </a>
                            </p>
                        @endif
                        <div class='h5'>
                            @error('summary_file')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 7: Status -->
                    <div class="gap-2 mb-2">
                        <label for="status" class="block text-gray-700 dark:text-gray-200">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="P" {{ old('status', $task->status) == 'P' ? 'selected' : '' }}>Pending
                                Approval</option>
                            <option value="E" {{ old('status', $task->status) == 'E' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="R" {{ old('status', $task->status) == 'R' ? 'selected' : '' }}>
                                Completed</option>
                            <option value="C" {{ old('status', $task->status) == 'C' ? 'selected' : '' }}>Under
                                Review</option>
                            <option value="X" {{ old('status', $task->status) == 'X' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                        <div class='h5'>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 8: Realization Date -->
                    <div class="gap-2 mb-2">
                        <label for="realization_date" class="block text-gray-700 dark:text-gray-200">Realization
                            Date</label>
                        <input type="date" name="realization_date" id="realization_date"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('realization_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        <div class='h5'>
                            @error('realization_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="gap-2 mb-2">
                        <label for="assigned_operator" class="block text-gray-700 dark:text-gray-200">Assigned
                            Operator</label>
                        <select name="assigned_operator" id="assigned_operator"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select an Operator</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}"
                                    {{ old('assigned_operator', $task->assigned_operator) == $operator->id ? 'selected' : '' }}>
                                    {{ $operator->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="h-5">
                            @error('assigned_operator')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-2">
                        <button type="submit"
                            class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update
                            Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
