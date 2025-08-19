<!DOCTYPE html>
<html>
<head>
    <title>Test POST Request</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test POST Request</h1>

    @auth
        <p>User: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
        <p>Session ID: {{ session()->getId() }}</p>
        <p>CSRF Token: {{ csrf_token() }}</p>
    @else
        <p>Not authenticated</p>
    @endauth

    <form method="POST" action="{{ route('admin.vehicles.store') }}">
        @csrf
        <input type="text" name="brand" value="Test Brand" required>
        <input type="text" name="model" value="Test Model" required>
        <input type="text" name="license_plate" value="B 9999 ZZZ" required>
        <input type="number" name="year" value="2020" required>
        <input type="text" name="type" value="SUV" required>
        <input type="number" name="passenger_capacity" value="7" required>
        <input type="text" name="fuel_type" value="Bensin" required>
        <input type="text" name="transmission" value="Manual" required>
        <input type="date" name="stnk_expiry" value="2025-12-31" required>
        <input type="text" name="condition" value="Baik" required>
        <input type="submit" value="Test Submit">
    </form>

    <script>
        // Log form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitted');
            console.log('CSRF Token:', document.querySelector('input[name="_token"]').value);
        });
    </script>
</body>
</html>
