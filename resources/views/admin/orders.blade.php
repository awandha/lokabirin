@extends('layouts.app')

@section('content')
    <h1>Admin Orders (Live)</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    {{-- Livewire component with polling --}}
    <livewire:admin-orders />
@endsection
