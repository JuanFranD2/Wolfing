<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - Wolfing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">

    <!-- Container for the Form -->
    <div class="w-full max-w-3xl p-8 bg-gray-800 rounded-lg shadow-xl">
        <!-- Company Title and Logo -->
        <div class="flex justify-center items-center mb-6">
            <img src="{{ asset('imgs/logotipo.jpg') }}" alt="Wolfing Logo" class="h-16 w-auto mr-4">
            <!-- Aquí cambia la URL de tu logo -->
            <h1 class="text-3xl font-bold text-white">Wolfing</h1>
        </div>

        <h2 class="text-xl font-semibold mb-4 text-center">Create Task for Client</h2>

        <!-- Form to create task -->
        <form action="{{ route('tasks.storeClientTask') }}" method="POST">
            @csrf

            <!-- Client (CIF) -->
            <div class="mb-4">
                <label for="cif" class="block text-gray-300">Client CIF</label>
                <input type="text" name="cif" id="cif"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('cif') }}">
                @error('cif')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <!-- Contact Person -->
            <div class="mb-4">
                <label for="contact_person" class="block text-gray-300">Contact Person</label>
                <input type="text" name="contact_person" id="contact_person"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('contact_person') }}">
                @error('contact_person')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contact Phone -->
            <div class="mb-4">
                <label for="contact_phone" class="block text-gray-300">Contact Phone</label>
                <input type="text" name="contact_phone" id="contact_phone"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('contact_phone') }}">
                @error('contact_phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-300">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contact Email -->
            <div class="mb-4">
                <label for="contact_email" class="block text-gray-300">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('contact_email') }}">
                @error('contact_email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-gray-300">Address</label>
                <input type="text" name="address" id="address"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('address') }}">
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- City -->
            <div class="mb-4">
                <label for="city" class="block text-gray-300">City</label>
                <input type="text" name="city" id="city"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('city') }}">
                @error('city')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Postal Code -->
            <div class="mb-4">
                <label for="postal_code" class="block text-gray-300">Postal Code</label>
                <input type="text" name="postal_code" id="postal_code"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md"
                    value="{{ old('postal_code') }}">
                @error('postal_code')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Province -->
            <!-- Province -->
            <div class="mb-4">
                <label for="province" class="block text-gray-300">Province</label>
                <select name="province" id="province"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md">
                    <option value="">Select a province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->cod }}"
                            {{ old('province') == $province->cod ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Previous Notes -->
            <div class="mb-4">
                <label for="previous_notes" class="block text-gray-300">Previous Notes</label>
                <textarea name="previous_notes" id="previous_notes" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md">{{ old('previous_notes') }}</textarea>
                @error('previous_notes')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Create Task</button>
            </div>
        </form>
    </div>

</body>

</html>
