@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-gray-800 text-lg">
                You are logged in as <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>.
            </p>

            @if (Auth::user()->role === 'admin')
                <a href="{{ url('/login-history') }}"
                   class="mt-3 sm:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded transition">
                    View Login History
                </a>
            @endif
        </div>

        <div class="bg-white p-8 shadow rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-2">Welcome to your PDF management system.</p>
        </div>
    </div>
@endsection
