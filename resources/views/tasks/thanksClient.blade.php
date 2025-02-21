<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Wolfing</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">

    <!-- Container for the Thank You Message -->
    <div class="w-full max-w-3xl p-8 bg-gray-800 rounded-lg shadow-xl">
        <!-- Company Title and Logo -->
        <div class="flex justify-center items-center mb-6">
            <img src="{{ asset('imgs/logotipo.jpg') }}" alt="Wolfing Logo" class="h-16 w-auto mr-4">
            <h1 class="text-3xl font-bold text-white">Wolfing</h1>
        </div>

        <h2 class="text-xl font-semibold mb-4 text-center">Thank You for Your Submission!</h2>

        <!-- Confirmation Message -->
        <div class="mb-4 text-center">
            <p class="text-lg text-gray-300">Your task has been successfully submitted. Thank you for your trust!</p>
            <p class="mt-4 text-sm text-gray-500">We will review your task and get back to you shortly.</p>
        </div>

        <!-- Button to Go Back to Form -->
        <div class="mb-4 text-center">
            <a href="{{ route('tasks.create.client') }}"
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                Back to Task Form
            </a>
        </div>
    </div>

</body>

</html>
