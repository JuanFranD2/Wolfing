<div x-data="{ showDeleteModal: false, taskToDelete: null }">
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Complete Task') }} #{{ $task->id }}
            </h2>
        </x-slot>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form action="{{ route('tasks.completeTask', $task->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Row 1: Client, Contact Person, Contact Email, Contact Phone (solo lectura) -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                            <div>
                                <input type="hidden" name="status" id="status" value="R">
                                <!-- Status set to "Completed" -->
                                <label for="client" class="block text-gray-700 dark:text-gray-200">Client</label>
                                <input type="text" name="client" id="client" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('client', $task->client) }}">
                            </div>
                            <div>
                                <label for="contact_person" class="block text-gray-700 dark:text-gray-200">Contact
                                    Person</label>
                                <input type="text" name="contact_person" id="contact_person" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('contact_person', $task->contact_person) }}">
                            </div>
                            <div>
                                <label for="contact_email" class="block text-gray-700 dark:text-gray-200">Contact
                                    Email</label>
                                <input type="email" name="contact_email" id="contact_email" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('contact_email', $task->contact_email) }}">
                            </div>
                            <div>
                                <label for="contact_phone" class="block text-gray-700 dark:text-gray-200">Contact
                                    Phone</label>
                                <input type="text" name="contact_phone" id="contact_phone" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('contact_phone', $task->contact_phone) }}">
                            </div>
                        </div>

                        <!-- Row 2: Description (solo lectura) -->
                        <div class="gap-2 mb-2">
                            <label for="description" class="block text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" id="description" rows="3" readonly
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <!-- Row 3: Address, Postal Code, City, Province (solo lectura) -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                            <div>
                                <label for="address" class="block text-gray-700 dark:text-gray-200">Address</label>
                                <input type="text" name="address" id="address" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('address', $task->address) }}">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-gray-700 dark:text-gray-200">Postal
                                    Code</label>
                                <input type="text" name="postal_code" id="postal_code" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('postal_code', $task->postal_code) }}">
                            </div>
                            <div>
                                <label for="city" class="block text-gray-700 dark:text-gray-200">City</label>
                                <input type="text" name="city" id="city" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('city', $task->city) }}">
                            </div>
                            <div>
                                <label for="province" class="block text-gray-700 dark:text-gray-200">Province</label>
                                <input type="text" name="province" id="province" readonly
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200"
                                    value="{{ old('province', $task->province) }}">
                            </div>
                        </div>

                        <!-- Row 4: Status (editable) -->
                        <div class="gap-2 mb-2">
                            <label for="status" class="block text-gray-700 dark:text-gray-200">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="E" {{ old('status', $task->status) == 'E' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="C" {{ old('status', $task->status) == 'C' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="X" {{ old('status', $task->status) == 'X' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            <div class='h5'>
                                @error('status')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Previous Notes (solo lectura) -->
                        <div class="gap-2 mb-2">
                            <label for="previous_notes" class="block text-gray-700 dark:text-gray-200">Previous
                                Notes</label>
                            <textarea name="previous_notes" id="previous_notes" rows="3" readonly
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-200">{{ old('previous_notes', $task->previous_notes) }}</textarea>
                        </div>


                        <!-- Row 5: Subsequent Notes (editable) -->
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

                        <!-- Row 6: Summary File (editable) -->
                        <div class="gap-2 mb-2">
                            <label for="summary_file" class="block text-gray-700 dark:text-gray-200">Summary File (PDF
                                only, max 10MB)</label>
                            <input type="file" name="summary_file" id="summary_file"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"{{ old('sumamry_file', $task->summary_file) }}>
                            <div class='h5'>
                                @error('summary_file')
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
</div>
