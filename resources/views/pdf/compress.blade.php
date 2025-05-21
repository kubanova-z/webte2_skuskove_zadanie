{{-- resources/views/pdf/compress.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">{{ __('messages.compress_title') }}</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.compress.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">
                    {{ __('messages.compress_choose_file') }}
                </label>
                <input
                        type="file"
                        name="pdf"
                        accept="application/pdf"
                        required
                        class="mt-1 block w-full"
                >
                <x-input-error :messages="$errors->get('pdf')" class="mt-2" />
            </div>

            <div class="mb-6">
                <label class="block font-medium text-gray-700 mb-1">
                    {{ __('messages.quality_dpi') }} (10–100%)
                </label>
                <input
                        type="range"
                        name="quality"
                        min="10"
                        max="100"
                        value="50"
                        class="w-full"
                >
                <div class="text-sm text-gray-600 mt-1">
                    <span id="quality-display">50%</span>
                </div>
            </div>

            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
                {{ __('messages.compress_button') }}
            </button>
        </form>
    </div>

    <script>
        // live‐update the % display
        document
            .querySelector('input[name="quality"]')
            .addEventListener('input', e => {
                document.getElementById('quality-display').innerText = e.target.value + '%';
            });
    </script>
@endsection