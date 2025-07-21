@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12 bg-gray-50 text-center">
        <div class="max-w-md w-full space-y-6">
            <svg class="mx-auto h-20 w-20 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.5 12.75l6 6 9-13.5"/>
            </svg>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Thank You!</h1>
            <p class="text-lg text-gray-600">Your order has been placed successfully.</p>
            <p class="text-gray-500">We’re preparing it for you at <strong>{{ $table->name }}</strong>.</p>

            <a href="{{ url('/order/' . $table->table_code) }}"
               class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Back to Menu
            </a>
        </div>
    </div>
@endsection
