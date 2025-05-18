@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Login History</h2>

        {{-- Buttons --}}
        <div x-data="{ showConfirm: false }" class="flex flex-wrap items-center gap-3 mb-6">
            <!-- Delete All Button -->
            <button @click="showConfirm = true"
                    type="button"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow">
                Delete All History
            </button>

            <!-- Export Button -->
            <a href="{{ url('/login-history/export') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                Export to CSV
            </a>

            <!-- Modal -->
            <div x-show="showConfirm"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                 x-cloak>
                <div class="bg-white rounded-lg p-6 max-w-md shadow-xl w-full text-center">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Delete All History?</h2>
                    <p class="text-gray-600 mb-6">This action cannot be undone. Are you sure?</p>

                    <div class="flex justify-center gap-4">
                        <!-- Cancel -->
                        <button @click="showConfirm = false"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                            Cancel
                        </button>

                        <!-- Confirm Delete -->
                        <form method="POST" action="{{ url('/login-history') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Confirm Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Time</th>
                    <th class="px-6 py-3">City</th>
                    <th class="px-6 py-3">Country</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($logins as $login)
                    <tr>
                        <td class="px-6 py-4">{{ $login->user->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4">{{ $login->login_time }}</td>
                        <td class="px-6 py-4">{{ $login->city ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $login->country ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
