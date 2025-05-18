<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <!-- Load Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .orbitron {
            font-family: 'Orbitron', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-white to-blue-100 min-h-screen flex items-center justify-center font-sans antialiased">
<div class="flex flex-col items-center text-center px-4">

    <!-- PDF Icon -->
    <div class="mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 12h6m2 6H7a2 2 0 01-2-2V8a2 2 0 012-2h6l5 5v9a2 2 0 01-2 2z"/>
        </svg>
    </div>

    <!-- Huge Boxed Title -->
    <div class="border-4 border-blue-700 bg-white px-10 py-6 rounded-lg shadow-xl mb-10">
        <h1 class="text-6xl sm:text-8xl text-blue-700 orbitron tracking-wide leading-tight">
            PDF Manager
        </h1>
    </div>

    <!-- Auth Buttons -->
    <div class="flex flex-col gap-4 w-48">
        <a href="{{ route('login') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-lg py-3 rounded shadow transition">
            Log In
        </a>
        <a href="{{ route('register') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-lg py-3 rounded shadow transition">
            Register
        </a>
    </div>
</div>
</body>
</html>
