<!DOCTYPE html>
<html>
<head>
    <title>Table QR Codes</title>
    <style>
        body { font-family: sans-serif; }
        .table { margin-bottom: 40px; text-align: center; }
    </style>
</head>
<body>
    <h1>Lokabirin - Table QR Codes</h1>

    @foreach($tables as $table)
        <div class="table">
            <h3>{{ $table->name }}</h3>
            {!! QrCode::size(200)->generate(url('/order/' . $table->table_code)) !!}
            <p>Scan to order for {{ $table->name }}</p>
        </div>
    @endforeach

</body>
</html>
