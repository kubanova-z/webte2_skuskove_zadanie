@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.remove_pages_title') }}</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.remove-pages.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.upload_pdf') }}</label>
                <input type="file" name="pdf" required class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.pages_to_remove') }}</label>
                <input type="text" name="pages" required class="mt-1 block w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ __('messages.remove_pages') }}
            </button>
        </form>
    </div>
@endsection
