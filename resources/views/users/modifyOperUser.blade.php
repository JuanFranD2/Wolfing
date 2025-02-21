<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modify Oper User') }} #{{ $user->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('operUsers.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden ID field -->
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-200">Name</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 dark:text-gray-200">Password</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('password') }}">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- DNI -->
                    <div class="mb-4">
                        <label for="dni" class="block text-gray-700 dark:text-gray-200">DNI</label>
                        <input type="text" name="dni" id="dni"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('dni', $user->dni) }}">
                        @error('dni')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 dark:text-gray-200">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 dark:text-gray-200">Address</label>
                        <input type="text" name="address" id="address"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('address', $user->address) }}">
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Type (Select) -->
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 dark:text-gray-200">Type</label>
                        <select name="type" id="type"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="oper" {{ old('type', $user->type) == 'oper' ? 'selected' : '' }}>Oper
                            </option>
                            <option value="admin" {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin
                            </option>public function update(ModifyOperUserRequest $request, $id)
                            {
                            $user = User::findOrFail($id);

                            // Si se ha proporcionado una nueva contraseña, encríptala antes de guardar
                            if ($request->filled('password')) {
                            $user->password = bcrypt($request->password);
                            }

                            // Actualiza los demás campos
                            $user->name = $request->name;
                            $user->email = $request->email;
                            $user->dni = $request->dni;
                            $user->phone = $request->phone;
                            $user->address = $request->address;
                            $user->type = $request->type;

                            $user->save();

                            return redirect()->route('operUsers.index')->with('success', 'User updated successfully.');
                            }

                        </select>
                        @error('type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-2">
                        <button type="submit"
                            class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update
                            Oper User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
