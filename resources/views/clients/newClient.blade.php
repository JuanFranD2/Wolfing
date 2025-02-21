<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Client') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf

                    <!-- CIF -->
                    <div class="mb-4">
                        <label for="cif" class="block text-gray-700 dark:text-gray-200">CIF</label>
                        <input type="text" name="cif" id="cif"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('cif') }}">
                        @error('cif')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-200">Name</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 dark:text-gray-200">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                        <input type="text" name="email" id="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bank Account -->
                    <div class="mb-4">
                        <label for="bank_account" class="block text-gray-700 dark:text-gray-200">Bank Account</label>
                        <input type="text" name="bank_account" id="bank_account"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('bank_account') }}">
                        @error('bank_account')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div class="mb-4">
                        <label for="country" class="block text-gray-700 dark:text-gray-200">Country</label>
                        <input type="text" name="country" id="country"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('country') }}">
                        @error('country')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div class="mb-4">
                        <label for="currency" class="block text-gray-700 dark:text-gray-200">Currency</label>
                        <input type="text" name="currency" id="currency"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('currency', 'EUR') }}">
                        @error('currency')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Monthly Fee -->
                    <div class="mb-4">
                        <label for="monthly_fee" class="block text-gray-700 dark:text-gray-200">Monthly Fee</label>
                        <input type="number" name="monthly_fee" id="monthly_fee"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('monthly_fee', 0) }}">
                        @error('monthly_fee')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-2">
                        <button type="submit"
                            class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create
                            Client</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
