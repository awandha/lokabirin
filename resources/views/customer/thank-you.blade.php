@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12 bg-gradient-to-br from-blue-100 via-green-100 to-blue-50 text-center">
        <div class="max-w-md w-full space-y-6 bg-white bg-opacity-80 rounded-xl shadow-lg p-8 border border-blue-200">
            <svg class="mx-auto h-20 w-20 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.5 12.75l6 6 9-13.5"/>
            </svg>

            <h1 class="text-3xl md:text-4xl font-bold text-blue-700">Thank You!</h1>
            <p class="text-lg text-green-700">Your order has been placed successfully.</p>
            <p class="text-blue-600">We’re preparing it for you at <strong class="text-green-600">{{ $table->name }}</strong>.</p>

            <a href="{{ url('/order/' . $table->table_code) }}"
               class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-blue-500 to-green-500 text-white rounded-lg shadow hover:from-blue-600 hover:to-green-600 transition font-semibold">
                Back to Menu
            </a>
        </div>
    </div>
@endsection
