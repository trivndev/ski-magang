<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    @vite('resources/css/app.css')
    @vite('resources/js/lottie.js')
    <meta name="robots" content="noindex">
</head>
<body class="min-h-screen bg-gray-50 text-gray-800 flex items-center justify-center p-6">
<main class="w-full max-w-2xl text-center">
    <x-lottie-animation id="error-404" src="{{ asset('lotties/404.lottie') }}" class="w-72 md:w-96 aspect-square mx-auto"/>
    <h1 class="mt-6 text-3xl md:text-4xl font-bold">404 - Page not found</h1>
    <p class="mt-2 text-gray-600">The page you're looking for doesn't exist or might have been moved.</p>
    <div class="mt-6 flex items-center justify-center gap-3">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black transition">Go Home</a>
        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Back</a>
    </div>
</main>
</body>
</html>
