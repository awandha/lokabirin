@extends('layouts.app')

@section('content')
    <livewire:customer-cart :tableCode="$table->table_code" />
@endsection
