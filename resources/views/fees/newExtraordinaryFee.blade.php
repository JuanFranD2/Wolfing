<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Extraordinary Fee') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <form action="{{ route('fees.store') }}" method="POST">
                        @csrf

                        <!-- CIF -->
                        <div class="mb-4">
                            <label for="cif" class="block text-gray-700 dark:text-gray-200">Client CIF</label>
                            <input type="text" name="cif" id="cif"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black"
                                value="{{ old('cif') }}">
                            <div style="height: 10px;">
                                @error('cif')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Concept -->
                        <div class="mb-4">
                            <label for="concept" class="block text-gray-700 dark:text-gray-200">Concept</label>
                            <input type="text" name="concept" id="concept"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black"
                                value="{{ old('concept') }}">
                            <div style="height: 10px;">
                                @error('concept')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700 dark:text-gray-200">Amount</label>
                            <input type="text" name="amount" id="amount"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black"
                                value="{{ old('amount') }}">
                            <div style="height: 10px;">
                                @error('amount')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 dark:text-gray-200">Notes</label>
                            <textarea name="notes" id="notes"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-black">{{ old('notes') }}</textarea>
                            <div style="height: 10px;">
                                @error('notes')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button type="submit"
                                class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Create Extraordinary Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
