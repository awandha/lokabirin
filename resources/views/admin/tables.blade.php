@extends('layouts.app')

@section('content')
<h1>Tables & QR Codes</h1>

<a href="{{ url('/admin/orders') }}">Back to Orders</a>

@foreach($tables as $table)
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
        <p><strong>{{ $table->name }}</strong> — Code: {{ $table->table_code }}</p>
        <p>
            {!! QrCode::size(200)->generate(url('/order/' . $table->table_code)) !!}
        </p>
    </div>
@endforeach

<p>
    <a href="{{ url('/admin/tables/qr-pdf') }}">Download QR Codes PDF</a>
</p>

@endsection
