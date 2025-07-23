@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">📋 Admin Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Orders --}}
        <a href="/admin/orders"
           class="flex items-center p-6 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 3h18M3 7h18M3 11h18M3 15h18M3 19h18"/>
            </svg>
            <span class="text-lg font-semibold">Manage Orders</span>
        </a>

        {{-- Tables --}}
        <a href="/admin/tables"
           class="flex items-center p-6 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            <span class="text-lg font-semibold">Manage Tables</span>
        </a>

        {{-- Menus --}}
        <a href="/admin/menu"
           class="flex items-center p-6 bg-purple-600 text-white rounded-xl shadow hover:bg-purple-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3M5 10h14M5 14h14M5 18h14"/>
            </svg>
            <span class="text-lg font-semibold">Manage Menus</span>
        </a>

        {{-- Reports --}}
        <a href="/admin/reports"
           class="flex items-center p-6 bg-yellow-600 text-white rounded-xl shadow hover:bg-yellow-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            <span class="text-lg font-semibold">View Reports</span>
        </a>

        {{-- Kitchen --}}
        <a href="/kitchen"
           class="flex items-center p-6 bg-red-600 text-white rounded-xl shadow hover:bg-red-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12h18M3 6h18M3 18h18"/>
            </svg>
            <span class="text-lg font-semibold">Kitchen View</span>
        </a>

        {{-- Export Reports (optional) --}}
        <a href="{{ route('admin.reports.export') }}"
           class="flex items-center p-6 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 mr-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-lg font-semibold">Export Reports</span>
        </a>
    </div>
</div>
@endsection
