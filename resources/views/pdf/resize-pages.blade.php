@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">Zmeniť veľkosť strán PDF</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pdf.resize-pages.process') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-gray-700">PDF súbor:</label>
                <input type="file" name="pdf" required class="mt-1 block w-full">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Nový formát strany:</label>
                <select name="size" class="mt-1 block w-full" required>
                    <option value="A4">A4 (595×842)</option>
                    <option value="A5">A5 (420×595)</option>
                    <option value="A6">A6 (297×420)</option>
                </select>
            </div>

            <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                Zmeniť veľkosť strán
            </button>
        </form>
    </div>
@endsection
