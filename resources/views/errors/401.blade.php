<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized</title>
    @vite('resources/css/app.css')
    @vite('resources/js/lottie.js')
    <meta name="robots" content="noindex">
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 flex items-center justify-center p-6">
<main class="w-full max-w-2xl text-center">
    <x-lottie-animation id="error-401" src="{{ asset('lotties/404.lottie') }}" class="w-72 md:w-96 aspect-square mx-auto"/>
    <h1 class="mt-6 text-3xl md:text-4xl font-bold">401 - Unauthorized</h1>
    <p class="mt-2 text-gray-600">You must be logged in with valid credentials to access this page.</p>
    <div class="mt-6 flex items-center justify-center gap-3">
        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black transition">Log In</a>
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Go Home</a>
    </div>
</main>
</body>
</html>
