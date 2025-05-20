@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-gray-800 text-lg">
                {{ __('messages.logged_in_as') }} <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>.
            </p>

            @if (Auth::user()->role === 'admin')
                <a href="{{ url('/login-history') }}"
                   class="mt-3 sm:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded transition">
                    {{ __('messages.view_login_history') }}
                </a>
            @endif
        </div>

        <div class="bg-white p-8 shadow rounded-lg">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.title') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('messages.welcome_message') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

            <a href="{{ route('pdf.remove-pages.form') }}" class="block bg-blue-100 border border-blue-300 p-6 rounded-lg shadow hover:bg-blue-200 transition">
                <h3 class="text-lg font-semibold text-blue-900">{{ __('messages.remove_pages_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.remove_pages_desc') }}</p>
            </a>

            <a href="{{ route('pdf.merge-pdfs.form') }}" class="block bg-green-100 border border-green-300 p-6 rounded-lg shadow hover:bg-green-200 transition">
                <h3 class="text-lg font-semibold text-green-900">{{ __('messages.merge_pdfs_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.merge_pdfs_desc') }}</p>
            </a>

            <a href="{{ route('pdf.pdf-to-jpg.form') }}" class="block bg-indigo-100 border border-indigo-300 p-6 rounded-lg shadow hover:bg-indigo-200 transition">
                <h3 class="text-lg font-semibold text-indigo-900">{{ __('messages.pdf_to_jpg_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.pdf_to_jpg_desc') }}</p>
            </a>

            <a href="{{ route('pdf.jpg-to-pdf.form') }}" class="block bg-purple-100 border border-purple-300 p-6 rounded-lg shadow hover:bg-purple-200 transition">
                <h3 class="text-lg font-semibold text-purple-900">{{ __('messages.jpg_to_pdf_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.jpg_to_pdf_desc') }}</p>
            </a>

            <a href="{{ route('pdf.rotate-pages.form') }}" class="block bg-yellow-100 border border-yellow-300 p-6 rounded-lg shadow hover:bg-yellow-200 transition">
                <h3 class="text-lg font-semibold text-yellow-900">{{ __('messages.rotate_pages_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.rotate_pages_desc') }}</p>
            </a>

            <a href="{{ route('pdf.split-pdf.form') }}" class="block bg-pink-100 border border-pink-300 p-6 rounded-lg shadow hover:bg-pink-200 transition">
                <h3 class="text-lg font-semibold text-pink-900">{{ __('messages.split_pdf_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.split_pdf_desc') }}</p>
            </a>


            {{-- FUNCTION - Protect PDF --}}
            <a href="{{ route('pdf.protect-pdf.form') }}" class="block bg-red-100 border border-red-300 p-6 rounded-lg shadow hover:bg-red-200 transition">
                <h3 class="text-lg font-semibold text-red-900">{{ __('messages.protect_pdf_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.protect_pdf_desc') }}</p>
            </a>

            {{-- FUNCTION - Unlock PDF --}}
            <a href="{{ route('pdf.unlock-pdf.form') }}" class="block bg-violet-100 border border-violet-300 p-6 rounded-lg shadow hover:bg-violet-200 transition">
                <h3 class="text-lg font-semibold text-violet-900">{{ __('messages.unlock_pdf_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.unlock_pdf_desc') }}</p>
            </a>

            {{-- FUNCTION - Resize Pages --}}
            <a href="{{ route('pdf.resize-pages.form') }}" class="block bg-orange-100 border border-orange-300 p-6 rounded-lg shadow hover:bg-orange-200 transition">
                <h3 class="text-lg font-semibold text-orange-900">{{ __('messages.resize_pages_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.resize_pages_desc') }}</p>
            </a>


            <a href="{{ route('pdf.compress.form') }}" class="block bg-pink-100 border border-pink-300 p-6 rounded-lg shadow hover:bg-pink-200 transition">
                <h3 class="text-lg font-semibold text-pink-900">{{ __('messages.compress_title') }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ __('messages.compress_desc') }}</p>
            </a>



        </div>
    </div>
@endsection
