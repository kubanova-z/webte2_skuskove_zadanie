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

{{--        Functions for PDFs--}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
{{--            FUNCTION - remove pages from pdf--}}
            <a href="{{ route('pdf.remove-pages.form') }}" class="block bg-blue-100 border border-blue-300 p-6 rounded-lg shadow hover:bg-blue-200 transition">
                <h3 class="text-lg font-semibold text-blue-900">Odstrániť strany z PDF</h3>
                <p class="text-sm text-gray-700 mt-2">Nahraj PDF a zadaj strany, ktoré chceš odstrániť.</p>
            </a>

{{--            FUNCTION - merge 2 or more pdfs--}}
            <a href="{{ route('pdf.merge-pdfs.form') }}" class="block bg-green-100 border border-green-300 p-6 rounded-lg shadow hover:bg-green-200 transition">
                <h3 class="text-lg font-semibold text-green-900">Zlúčiť PDF súbory</h3>
                <p class="text-sm text-gray-700 mt-2">Nahraj viacero PDF súborov a spoj ich do jedného.</p>
            </a>

{{--            FUNCTION - PDF to JPG--}}
            <a href="{{ route('pdf.pdf-to-jpg.form') }}" class="block bg-indigo-100 border border-indigo-300 p-6 rounded-lg shadow hover:bg-indigo-200 transition">
                <h3 class="text-lg font-semibold text-indigo-900">PDF → JPG</h3>
                <p class="text-sm text-gray-700 mt-2">Konvertuj každú stranu PDF do obrázka (.jpg).</p>
            </a>

{{--            FUNCTION - JPG to PDF--}}
            <a href="{{ route('pdf.jpg-to-pdf.form') }}" class="block bg-purple-100 border border-purple-300 p-6 rounded-lg shadow hover:bg-purple-200 transition">
                <h3 class="text-lg font-semibold text-purple-900">JPG → PDF</h3>
                <p class="text-sm text-gray-700 mt-2">Spoj obrázky .jpg do jedného PDF súboru.</p>
            </a>

{{--            FUNCTION - Rotate Pages--}}
            <a href="{{ route('pdf.rotate-pages.form') }}" class="block bg-yellow-100 border border-yellow-300 p-6 rounded-lg shadow hover:bg-yellow-200 transition">
                <h3 class="text-lg font-semibold text-yellow-900">Otočiť strany PDF</h3>
                <p class="text-sm text-gray-700 mt-2">Vyber strany, ktoré chceš otočiť o 90°, 180° alebo 270°.</p>
            </a>

{{--            FUNCTION - Split PDF--}}
            <a href="{{ route('pdf.split-pdf.form') }}" class="block bg-pink-100 border border-pink-300 p-6 rounded-lg shadow hover:bg-pink-200 transition">
                <h3 class="text-lg font-semibold text-pink-900">Rozdeliť PDF</h3>
                <p class="text-sm text-gray-700 mt-2">Rozdeľ PDF po 1 alebo viacerých stranách do samostatných súborov.</p>
            </a>


        </div>


    </div>
@endsection
