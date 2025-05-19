@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">JPG → PDF</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.jpg-to-pdf.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Vyber obrázky (.jpg):</label>
                <input type="file" name="images[]" multiple required accept=".jpg,.jpeg" class="mt-1 block w-full">
            </div>

            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Konvertovať do PDF
            </button>
        </form>
    </div>
@endsection
