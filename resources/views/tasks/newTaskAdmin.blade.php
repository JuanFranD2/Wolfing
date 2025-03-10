<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Task Admin') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <!-- Row 1: Client, Contact Person, Contact Email, Contact Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-2">
                        <input type="hidden" name="status" id="status "value="E">
                        <!-- Client Select Field -->
                        <div>
                            <label for="client" class="block text-gray-700 dark:text-gray-200">Client</label>
                            <select name="client" id="client"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select a Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->name }}"
                                        {{ old('client') == $client->name ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                value="{{ old('contact_person') }}">
                            <div class="h-5">
                                @error('contact_person')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="contact_email" class="block text-gray-700 dark:text-gray-200">Contact
                                Email</label>
                            <input type="text" name="contact_email" id="contact_email"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('contact_email') }}">
                            <div class="h-5">
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
                                value="{{ old('contact_phone') }}">
                            <div class="h-5">
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
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                        <div class="h-5">
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
                                value="{{ old('address') }}">
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="postal_code" class="block text-gray-700 dark:text-gray-200">Postal
                                Code</label>
                            <input type="text" name="postal_code" id="postal_code"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('postal_code') }}">
                            <div class="h-5">
                                @error('postal_code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="city" class="block text-gray-700 dark:text-gray-200">City</label>
                            <input type="text" name="city" id="city"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('city') }}">
                            <div class="h-5">
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
                                        {{ old('province') == $province->cod ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="h-5">
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
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('previous_notes') }}</textarea>
                        <div class="h-5">
                            @error('previous_notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 5: Assigned Operator -->
                    <div class="gap-2 mb-2">
                        <label for="assigned_operator" class="block text-gray-700 dark:text-gray-200">Assigned
                            Operator</label>
                        <select name="assigned_operator" id="assigned_operator"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select an Operator</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}"
                                    {{ old('assigned_operator') == $operator->id ? 'selected' : '' }}>
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
                            class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create
                            Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
