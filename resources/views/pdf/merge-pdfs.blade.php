@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.merge_pdfs_title') }}</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.merge-pdfs.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">{{ __('messages.select_pdfs') }}</label>
                <input type="file" name="pdfs[]" multiple required class="mt-1 block w-full">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ __('messages.merge_files') }}
            </button>
        </form>
    </div>
@endsection
