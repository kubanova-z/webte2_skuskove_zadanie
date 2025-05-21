@extends('layouts.app')

@section('header')
    User Guide
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        @include('partials.user-guide-content')

        <a href="{{ route('user-guide.pdf') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            {{ __('messages.download_pdf') }}
        </a>
    </div>
@endsection
