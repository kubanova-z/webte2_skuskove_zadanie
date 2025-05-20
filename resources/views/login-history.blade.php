@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.login_history') }}</h2>

        {{-- Buttons --}}
        <div x-data="{ showConfirm: false }" class="flex flex-wrap items-center gap-3 mb-6">

            <!-- Delete All Button -->
            <button @click="showConfirm = true"
                    type="button"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow">
                {{ __('messages.delete_all_history') }}
            </button>

            <!-- Export Button -->
            <a href="{{ url('/login-history/export') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                {{ __('messages.export_csv') }}
            </a>

            <!-- Modal -->
            <div x-show="showConfirm"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                 x-cloak>
                <div class="bg-white rounded-lg p-6 max-w-md shadow-xl w-full text-center">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.confirm_delete_title') }}</h2>
                    <p class="text-gray-600 mb-6">{{ __('messages.confirm_delete_warning') }}</p>

                    <div class="flex justify-center gap-4">
                        <!-- Cancel -->
                        <button @click="showConfirm = false"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                            {{ __('messages.cancel') }}
                        </button>

                        <!-- Confirm Delete -->
                        <form method="POST" action="{{ url('/login-history') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                {{ __('messages.confirm') }}
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
                    <th class="px-6 py-3">{{ __('messages.user') }}</th>
                    <th class="px-6 py-3">{{ __('messages.time') }}</th>
                    <th class="px-6 py-3">{{ __('messages.city') }}</th>
                    <th class="px-6 py-3">{{ __('messages.country') }}</th>
                    <th class="px-6 py-3">{{ __('messages.used_features') }}</th>

                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach ($logins as $login)
                    <tr>
                        <td class="px-6 py-4">{{ $login->user->name ?? __('messages.unknown') }}</td>
                        <td class="px-6 py-4">{{ $login->login_time }}</td>
                        <td class="px-6 py-4">{{ $login->city ?? __('messages.na') }}</td>
                        <td class="px-6 py-4">{{ $login->country ?? __('messages.na') }}</td>
                        <td class="px-6 py-4">
                            @if (!empty($login->used_features))
                                <ul class="list-disc list-inside">
                                    @foreach ($login->used_features as $feature)
                                        <li>{{ __('features.' . $feature) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-400 italic">{{ __('messages.none') }}</span>
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
