@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.rotate_pages_title') }}</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.rotate-pages.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.upload_pdf') }}</label>
                <input type="file" name="pdf" required class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.pages_to_rotate') }}</label>
                <input type="text" name="pages" required class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.rotation_angle') }}</label>
                <select name="angle" class="mt-1 block w-full">
                    <option value="90">90°</option>
                    <option value="180">180°</option>
                    <option value="270">270°</option>
                </select>
            </div>

            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                {{ __('messages.rotate_pages') }}
            </button>
        </form>
    </div>
@endsection
